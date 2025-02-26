<?php

namespace App\Http\Controllers;

use App\Models\CategoryPage;
use App\Models\FamilyCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoryPageController extends Controller
{
        /**
         * Shows the category page for a given slug
         *
         * @param string $slug The slug of the category page to show
         *
         * @return \Illuminate\Contracts\View\View The category page view
         */
    public function show($slug)
    {
        $page = CategoryPage::where('slug', $slug)->firstOrFail();
        $mainCategory = FamilyCategory::find($page->family_category_id);
        
        // Get all products for this category and its subcategories with all necessary details
        $products = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->leftJoin('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->where(function($query) use ($mainCategory) {
                $query->where('products.family_category_id', $mainCategory->family_category_id)
                    ->orWhereIn('products.family_category_id', function($subquery) use ($mainCategory) {
                        $subquery->select('family_category_id')
                            ->from('family_categories')
                            ->where('parent_category_id', $mainCategory->family_category_id);
                    });
            })
            ->where(function($query) {
                $query->where('products.price_per_unit', '>', 0)
                    ->whereNotNull('products.price_per_unit');
            })
            ->select(
                'products.*',
                'product_details.*',
                'product_media.*',
                'shipping_details.weight'
            )
            ->get();

        // Group products by style first
        $groupedProducts = $products->groupBy('style')->map(function($styleProducts) {
            // For each style, group products by their unique attributes
            $productsByHeight = $styleProducts->groupBy('size1')->map(function($sameHeightProducts) {
                // Get all colors available for this height
                $colors = $sameHeightProducts->pluck('color')->filter()->unique();
                
                // Take the first product as base and attach all available colors
                $baseProduct = $sameHeightProducts->first();
                $baseProduct->available_colors = $colors;
                
                // Store color variants with all necessary data
                $baseProduct->color_variants = $sameHeightProducts->map(function($product) {
                    return [
                        'color' => $product->color,
                        'item_no' => $product->item_no,
                        'size2' => $product->size2,
                        'weight' => $product->weight,
                        'product_id' => $product->product_id
                    ];
                })->keyBy('color');
                
                return $baseProduct;
            })->sortBy('size1');

            // Only return the group if it has products
            if ($productsByHeight->isNotEmpty()) {
                return [
                    'products' => $productsByHeight,
                    'image' => $styleProducts->first()->large_image ?? null
                ];
            }
            return null;
        })->filter(); // Remove any empty groups

        return view('category-page', [
            'page' => $page,
            'mainCategory' => $mainCategory,
            'groupedProducts' => $groupedProducts
        ]);
    }
}

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
                'shipping_details.weight',
                'shipping_details.shipping_length',
                'shipping_details.shipping_width',
                'shipping_details.shipping_height',
                'shipping_details.shipping_class'
            )
            ->get();

        // Check which grouping fields have data
        $groupingFields = [];
        if ($products->whereNotNull('style')->count() > 0) {
            $groupingFields[] = 'style';
        }
        if ($products->whereNotNull('specialty')->count() > 0) {
            $groupingFields[] = 'specialty';
        }
        if ($products->whereNotNull('spacing')->count() > 0) {
            $groupingFields[] = 'spacing';
        }
        if ($products->whereNotNull('coating')->count() > 0) {
            $groupingFields[] = 'coating';
        }

        // If no grouping fields are available, return products as is
        if (empty($groupingFields)) {
            $groupedProducts = collect([
                'groups' => [
                    [
                        'title' => $mainCategory->name,
                        'products' => $this->processProducts($products),
                        'image' => $products->first()->large_image ?? null
                    ]
                ]
            ]);
        } else {
            // Group products by the available fields
            $groupedProducts = $this->groupProductsByFields($products, $groupingFields);
        }

        return view('category-page', [
            'page' => $page,
            'mainCategory' => $mainCategory,
            'groupedProducts' => $groupedProducts,
            'groupingFields' => $groupingFields
        ]);
    }

    private function groupProductsByFields($products, $fields) {
        $result = [];
        
        // Start with the first level of grouping
        $currentGroups = $products->groupBy($fields[0]);
        
        foreach ($currentGroups as $firstKey => $firstGroup) {
            $group = [
                'title' => $firstKey,
                'products' => collect(),
                'subgroups' => [],
                'image' => $firstGroup->first()->large_image ?? null
            ];
            
            if (count($fields) > 1) {
                // Handle nested grouping
                foreach ($fields as $index => $field) {
                    if ($index === 0) continue; // Skip the first field as we already used it
                    
                    $subGroups = $firstGroup->groupBy($field);
                    foreach ($subGroups as $key => $subGroup) {
                        if ($index === count($fields) - 1) {
                            // Last level, process the products
                            $group['subgroups'][] = [
                                'title' => "$firstKey - $key",
                                'products' => $this->processProducts($subGroup),
                                'image' => $subGroup->first()->large_image ?? null
                            ];
                        } else {
                            // More levels to go
                            $group['subgroups'][] = [
                                'title' => "$firstKey - $key",
                                'products' => collect(),
                                'subgroups' => $this->groupProductsByFields($subGroup, array_slice($fields, $index + 1))['groups'],
                                'image' => $subGroup->first()->large_image ?? null
                            ];
                        }
                    }
                }
            } else {
                // Single level grouping
                $group['products'] = $this->processProducts($firstGroup);
            }
            
            $result[] = $group;
        }
        
        return ['groups' => $result];
    }

    private function processProducts($products) {
        return $products->groupBy('size1')->map(function($sameHeightProducts) {
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
    }
}

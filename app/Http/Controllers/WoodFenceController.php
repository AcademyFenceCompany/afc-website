<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class WoodFenceController extends Controller
{
    public function index()
    {
        // Fetch Wood Fence Subcategories
        $woodFenceSubcategories = DB::table('family_categories')
            ->where('parent_category_id', 16) // Wood Fence parent category
            ->select('family_category_id', 'family_category_name', 'category_description')
            ->get();

        $subcategoriesWithSpacing = [];
        foreach ($woodFenceSubcategories as $subcategory) {
            $image = DB::table('general_media')
                ->where('family_category_id', $subcategory->family_category_id)
                ->value('image');

            $spacingOptions = DB::table('product_details')
                ->where('family_category_id', $subcategory->family_category_id)
                ->whereNotNull('spacing')
                ->distinct()
                ->pluck('spacing');

            $subcategoriesWithSpacing[] = [
                'id' => $subcategory->family_category_id,
                'name' => $subcategory->family_category_name,
                'description' => $subcategory->category_description ?? 'No description',
                'image' => $image ?? '/default.png',
                'spacing_options' => $spacingOptions,
            ];
        }

        // Other implement ------------------------------------------------------
        $test_subs = DB::table('family_categories')
            ->join('general_media', 'family_categories.family_category_id', '=', 'general_media.family_category_id')
            ->join('products', 'products.family_category_id', '=', 'family_categories.family_category_id')
            ->join('product_details', 'product_details.product_id', '=', 'products.product_id')
            ->where('family_categories.parent_category_id', 16)
            ->where('family_categories.family_category_id', '!=', 16)
            ->where('products.product_name', 'not like', '%gate%')
            ->select(
                'family_categories.family_category_id',
                'family_categories.family_category_name',
                'product_details.style',
                'product_details.spacing',
                'products.subcategory_id',
                'products.product_name',
                'general_media.image',
                'family_categories.category_description'
            )
            ->distinct()
            ->get();

        $grouped = $test_subs->groupBy('family_category_id');

        $wood_categories = $grouped->map(function ($group) {
            $spacing = $group->pluck('spacing')->unique()->values()->filter(function ($item) {
                return !is_null($item);
            });
            $style = $group->pluck('style')->unique()->values()->filter(function ($item) {
                return !is_null($item);
            });
            return
                [
                    'family_category_id' => $group->pluck('family_category_id')->unique()->values()->first(),
                    'family_category_name' => $group->pluck('family_category_name')->unique()->values()->first(),
                    'image' => $group->pluck('image')->unique()->values()->first(),
                    'style' => $style->isNotEmpty() ? $group->pluck('style')->unique()->values()->toArray() : null,
                    'spacing' => $spacing->isNotEmpty() ? $group->pluck('spacing')->unique()->values()->toArray() : null,
                    'category_description' => $group->pluck('category_description')->unique()->values()->first()
                ];
        });

        return view('categories.woodfence', ['subcategories' => $subcategoriesWithSpacing, 'wood_categories' => $wood_categories]);
    }

    public function getMinPriceBySubcatID($subcatid)
    {
        $price = DB::table('products')
            ->where('products.subcategory_id', $subcatid)
            ->min('products.price_per_unit');

        return $price;
    }

    public function productBySubcatID($subcatid)
    {
        $product_id_distinct = DB::table('products')
            ->where('products.subcategory_id', $subcatid)
            ->where('products.price_per_unit', $this->getMinPriceBySubcatID($subcatid))
            ->value('products.product_id');


        return $product_id_distinct;
    }

    public function getProductsGroupedByStyle($subcategoryId, $spacing = null)
    {
        // Get styleTitle from the request if it exists
        $styleTitle = request()->query('styleTitle');
        
        $query = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'product_media.product_id', '=', 'products.product_id')
            ->where('products.family_category_id', $subcategoryId)
            ->where('products.product_name', 'not like', '%gate%');

        if ($spacing) {
            $query->where('product_details.spacing', $spacing);
        }

        $details = $query->select(
                'product_details.style',
                'product_details.specialty',
                'product_details.spacing',
                'product_details.material',
                'products.family_category_id',
                'products.subcategory_id',
                'product_media.general_image'
            )
            ->distinct()
            ->get();

        // First try to group by style
        if ($details->whereNotNull('style')->count() > 0) {
            // Get unique styles and create initial grouping structure
            $styles = $details->pluck('style')->unique()->filter()->mapWithKeys(function($style) {
                return [$style => collect([
                    'style' => $style,
                    'combos' => collect([])
                ])];
            });

            $grouped = $details->reduce(function ($carry, $group) {
                if (!$group->style) return $carry;
                
                $hold = collect([
                    'product_id' => $this->productBySubcatID($group->subcategory_id),
                    'subcategory_id' => $group->subcategory_id,
                    'specialty' => $group->specialty,
                    'spacing' => $group->spacing,
                    'material' => $group->material,
                    'general_image' => $group->general_image,
                    'price' => $this->getMinPriceBySubcatID($group->subcategory_id)
                ]);

                if ($carry->has($group->style)) {
                    $carry->get($group->style)->get('combos')->push($hold);
                }

                return $carry;
            }, $styles);

            return view('categories.woodfence-specs', [
                'styleGroups' => $grouped,
                'groupBy' => 'style',
                'styleTitle' => $styleTitle,
                'spacing' => $spacing
            ]);
        }
        // If no style, try to group by specialty
        elseif ($details->whereNotNull('specialty')->count() > 0) {
            $specialties = $details->pluck('specialty')->unique()->filter()->map(function($specialty) {
                return collect([
                    'specialty' => $specialty,
                    'products' => collect([])
                ]);
            })->keyBy('specialty');

            $grouped = $details->reduce(function ($carry, $group) {
                if (!$group->specialty) return $carry;

                $hold = collect([
                    'product_id' => $this->productBySubcatID($group->subcategory_id),
                    'subcategory_id' => $group->subcategory_id,
                    'spacing' => $group->spacing,
                    'material' => $group->material,
                    'general_image' => $group->general_image,
                    'price' => $this->getMinPriceBySubcatID($group->subcategory_id)
                ]);

                if ($carry->has($group->specialty)) {
                    $carry->get($group->specialty)['products']->push($hold);
                }

                return $carry;
            }, $specialties);

            return view('categories.woodfence-specs', [
                'specialtyGroups' => $grouped,
                'groupBy' => 'specialty',
                'styleTitle' => $styleTitle,
                'spacing' => $spacing
            ]);
        }
        // If no grouping is possible, show products in a grid
        else {
            $products = $details->map(function ($product) {
                return collect([
                    'product_id' => $this->productBySubcatID($product->subcategory_id),
                    'subcategory_id' => $product->subcategory_id,
                    'style' => $product->style,
                    'specialty' => $product->specialty,
                    'spacing' => $product->spacing,
                    'material' => $product->material,
                    'general_image' => $product->general_image,
                    'price' => $this->getMinPriceBySubcatID($product->subcategory_id)
                ]);
            });

            return view('categories.woodfence-specs', [
                'products' => $products,
                'groupBy' => 'none',
                'styleTitle' => $styleTitle,
                'spacing' => $spacing
            ]);
        }
    }
}

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


    // public function getProductsGroupedByStyle($subcategoryId, $spacing, $showAll = false)
    // {
    //     $formattedSpacing = str_replace('_', ' ', $spacing);
    //     $defaultPicketStyles = ['Slant Ear', 'Gothic Point', 'French Gothic'];

    //     $validCombos = DB::table('products')
    //         ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
    //         ->select('style', 'speciality')
    //         ->where([
    //             ['subcategory_id', $subcategoryId],
    //             ['spacing', $formattedSpacing]
    //         ]);

    //     if (!$showAll) {
    //         $validCombos->whereIn('speciality', $defaultPicketStyles);
    //     }

    //     $validCombos = $validCombos->distinct()->get();

    //     $styleGroups = [];
    //     foreach ($validCombos->groupBy('style') as $style => $combos) {
    //         $styleProducts = [];
    //         foreach ($combos as $combo) {
    //             $product = DB::table('products')
    //                 ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
    //                 ->join('product_media', 'products.product_id', '=', 'product_media.product_id')
    //                 ->where([
    //                     ['products.subcategory_id', $subcategoryId],
    //                     ['product_details.spacing', $formattedSpacing],
    //                     ['product_details.style', $combo->style],
    //                     ['product_details.speciality', $combo->speciality]
    //                 ])
    //                 ->first();

    //             if ($product) {
    //                 $styleProducts[] = $product;
    //             }
    //         }

    //         if (!empty($styleProducts)) {
    //             $styleGroups[] = [
    //                 'style' => $style,
    //                 'products' => $styleProducts,
    //                 'showAll' => $showAll
    //             ];
    //         }
    //     }

    //     return view('categories.woodfence-specs', ['styleGroups' => $styleGroups]);
    // }

    public function getPriceBySubCatID($subcatid)
    {
        $price = DB::table('products')
            ->where('products.subcategory_id', $subcatid)
            ->min('products.price_per_unit');

        return $price;
    }

    public function getProductsGroupedByStyle($subcategoryId, $spacing, $showAll = false)
    {

        $details = DB::table('products')
            ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('product_media', 'product_media.product_id', '=', 'products.product_id')
            ->where('products.family_category_id', $subcategoryId)
            ->where('product_details.spacing', $spacing)
            ->whereNotNull('product_details.style')
            ->where('products.product_name', 'not like', '%gate%')
            ->select(
                'product_details.style',
                'product_details.speciality',
                'product_details.spacing',
                'product_details.material',
                'products.family_category_id',
                'products.subcategory_id',
                'product_media.general_image'
            )
            ->distinct()
            ->get();

        $styles = collect((array) [
            'Concave' => collect((array) [
                'style' => 'Concave',
                'combos' => collect((array)[]),
            ]),
            'Convex' => collect((array) [
                'style' => 'Convex',
                'combos' => collect((array)[]),
            ]),
            'Straight on Top' => collect((array) [
                'style' => 'Straight on Top',
                'combos' => collect((array)[]),
            ]),
        ]);

        $grouped = $details->reduce(function ($carry, $group) {
            $hold = collect((array) [
                'subcategory_id' => $group->subcategory_id,
                'speciality' => $group->speciality,
                'spacing' => $group->spacing,
                'material' => $group->material,
                'general_image' => $group->general_image,
                'price' => $this->getPriceBySubCatID($group->subcategory_id)
            ]);

            $styleGroup = $carry->get($group->style);
            if ($styleGroup !== null && $styleGroup->has('combos')) {
                $carry->get($group->style)->get('combos')->push($hold);
            }

            return $carry;
        }, $styles);

        return view('categories.woodfence-specs', ['styleGroups' => $grouped]);
    }
}

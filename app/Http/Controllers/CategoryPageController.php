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

        if ($page->template === 'welded_wire') {
            // Welded wire template logic
            $meshSize_products = [];
            $groupedByMesh = $products->groupBy('size1');
            
            foreach ($groupedByMesh as $meshSize => $sameHeightProducts) {
                $gaugeProducts = [];
                $sameHeightProducts = $sameHeightProducts->groupBy('size2');
                
                foreach ($sameHeightProducts as $gauge => $sameGaugeProducts) {
                    $coatingProducts = [];
                    $sameGaugeProducts = $sameGaugeProducts->groupBy('coating');
                    
                    foreach ($sameGaugeProducts as $coating => $sameCoatingProducts) {
                        // Group same products with different colors
                        $colorGroups = $sameCoatingProducts->groupBy(function($product) {
                            return $product->size1 . '-' . $product->size2 . '-' . $product->coating;
                        })->map(function($group) {
                            $baseProduct = $group->first();
                            $colors = $group->pluck('color')->filter();
                            $baseProduct->available_colors = $colors;
                            $baseProduct->color_variants = $group->mapWithKeys(function($product) {
                                return [$product->color => [
                                    'color' => $product->color,
                                    'item_no' => $product->item_no,
                                    'size2' => $product->size2,
                                    'weight' => $product->weight,
                                    'product_id' => $product->product_id
                                ]];
                            });
                            return $baseProduct;
                        })->values();

                        $coatingProducts[] = [
                            'title' => $coating,
                            'products' => $colorGroups
                        ];
                    }
                    
                    $gaugeProducts[] = [
                        'title' => $gauge,
                        'subgroups' => $coatingProducts
                    ];
                }
                
                $meshSize_products[] = [
                    'title' => $meshSize,
                    'subgroups' => $gaugeProducts,
                    'image' => $sameHeightProducts->first()->first()->large_image ?? null
                ];
            }
            
            return view('category-page', [
                'page' => $page,
                'mainCategory' => $mainCategory,
                'groupedProducts' => ['groups' => $meshSize_products],
                'isWeldedWire' => true
            ]);
        }

        // Standard template logic
        $groups = [];
        $styleGroups = $products->whereNotNull('style')->groupBy('style');
        
        foreach ($styleGroups as $style => $styleProducts) {
            $group = [
                'title' => $style ?: 'Other',
                'image' => $styleProducts->first()->large_image ?? null,
                'subgroups' => []
            ];

            // Group by specialty within style
            $specialtyGroups = $styleProducts->whereNotNull('specialty')->groupBy('specialty');
            
            foreach ($specialtyGroups as $specialty => $specialtyProducts) {
                // Group same products with different colors within each specialty
                $uniqueProducts = $specialtyProducts->groupBy(function($product) {
                    return $product->style . '-' . $product->specialty . '-' . $product->size1 . '-' . $product->size2;
                })->map(function($sameProducts) {
                    $baseProduct = $sameProducts->first();
                    $colors = $sameProducts->pluck('color')->filter();
                    $baseProduct->available_colors = $colors;
                    $baseProduct->color_variants = $sameProducts->mapWithKeys(function($product) {
                        return [$product->color => [
                            'color' => $product->color,
                            'item_no' => $product->item_no,
                            'size2' => $product->size2,
                            'weight' => $product->weight,
                            'product_id' => $product->product_id
                        ]];
                    });
                    return $baseProduct;
                })->values();

                $group['subgroups'][] = [
                    'title' => $specialty ?: 'Other',
                    'products' => $uniqueProducts
                ];
            }

            // Handle products without specialty
            $noSpecialtyProducts = $styleProducts->whereNull('specialty');
            if ($noSpecialtyProducts->isNotEmpty()) {
                $uniqueProducts = $noSpecialtyProducts->groupBy(function($product) {
                    return $product->style . '-' . $product->size1 . '-' . $product->size2;
                })->map(function($sameProducts) {
                    $baseProduct = $sameProducts->first();
                    $colors = $sameProducts->pluck('color')->filter();
                    $baseProduct->available_colors = $colors;
                    $baseProduct->color_variants = $sameProducts->mapWithKeys(function($product) {
                        return [$product->color => [
                            'color' => $product->color,
                            'item_no' => $product->item_no,
                            'size2' => $product->size2,
                            'weight' => $product->weight,
                            'product_id' => $product->product_id
                        ]];
                    });
                    return $baseProduct;
                })->values();

                $group['subgroups'][] = [
                    'title' => 'Other',
                    'products' => $uniqueProducts
                ];
            }

            if (!empty($group['subgroups'])) {
                $groups[] = $group;
            }
        }

        // If no style groups, show all products grouped by specialty
        if (empty($groups)) {
            $specialtyGroups = $products->whereNotNull('specialty')->groupBy('specialty');
            
            if ($specialtyGroups->isNotEmpty()) {
                $mainGroup = [
                    'title' => $mainCategory->family_category_name,
                    'image' => $products->first()->large_image ?? null,
                    'subgroups' => []
                ];

                foreach ($specialtyGroups as $specialty => $specialtyProducts) {
                    $uniqueProducts = $specialtyProducts->groupBy(function($product) {
                        return $product->specialty . '-' . $product->size1 . '-' . $product->size2;
                    })->map(function($sameProducts) {
                        $baseProduct = $sameProducts->first();
                        $colors = $sameProducts->pluck('color')->filter();
                        $baseProduct->available_colors = $colors;
                        $baseProduct->color_variants = $sameProducts->mapWithKeys(function($product) {
                            return [$product->color => [
                                'color' => $product->color,
                                'item_no' => $product->item_no,
                                'size2' => $product->size2,
                                'weight' => $product->weight,
                                'product_id' => $product->product_id
                            ]];
                        });
                        return $baseProduct;
                    })->values();

                    $mainGroup['subgroups'][] = [
                        'title' => $specialty ?: 'Other',
                        'products' => $uniqueProducts
                    ];
                }

                $groups[] = $mainGroup;
            } else {
                // No specialties, show all products together
                $uniqueProducts = $products->groupBy(function($product) {
                    return $product->size1 . '-' . $product->size2;
                })->map(function($sameProducts) {
                    $baseProduct = $sameProducts->first();
                    $colors = $sameProducts->pluck('color')->filter();
                    $baseProduct->available_colors = $colors;
                    $baseProduct->color_variants = $sameProducts->mapWithKeys(function($product) {
                        return [$product->color => [
                            'color' => $product->color,
                            'item_no' => $product->item_no,
                            'size2' => $product->size2,
                            'weight' => $product->weight,
                            'product_id' => $product->product_id
                        ]];
                    });
                    return $baseProduct;
                })->values();

                $groups[] = [
                    'title' => $mainCategory->family_category_name,
                    'image' => $products->first()->large_image ?? null,
                    'subgroups' => [
                        [
                            'title' => 'All Products',
                            'products' => $uniqueProducts
                        ]
                    ]
                ];
            }
        }

        return view('category-page', [
            'page' => $page,
            'mainCategory' => $mainCategory,
            'groupedProducts' => ['groups' => $groups],
            'isWeldedWire' => false
        ]);
    }
}

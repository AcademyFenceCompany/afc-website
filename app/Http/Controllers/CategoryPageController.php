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
            ->leftJoin('product_media', 'products.product_id', '=', 'product_media.product_id')
            ->leftJoin('shipping_details', 'products.product_id', '=', 'shipping_details.product_id')
            ->where(function($query) use ($mainCategory, $page) {
                if ($page->template === 'razor_wire') {
                    $query->where('products.family_category_id', 470)
                        ->orWhereIn('products.family_category_id', function($subquery) {
                            $subquery->select('family_category_id')
                                ->from('family_categories')
                                ->where('parent_category_id', 470);
                        });
                } else {
                    $query->where('products.family_category_id', $mainCategory->family_category_id)
                        ->orWhereIn('products.family_category_id', function($subquery) use ($mainCategory) {
                            $subquery->select('family_category_id')
                                ->from('family_categories')
                                ->where('parent_category_id', $mainCategory->family_category_id);
                        });
                }
            })
            ->where(function($query) {
                $query->where('products.price_per_unit', '>', 0)
                    ->whereNotNull('products.price_per_unit');
            })
            ->select(
                'products.*',
                'product_details.*',
                'product_media.large_image',
                'product_media.small_image',
                'shipping_details.weight',
                'shipping_details.shipping_length',
                'shipping_details.shipping_width',
                'shipping_details.shipping_height',
                'shipping_details.shipping_class'
            )
            ->get();

        // Debug log the products
        \Log::info('Products Query', [
            'category_id' => $mainCategory->family_category_id,
            'product_count' => $products->count(),
            'products' => $products->map(function($p) {
                return [
                    'id' => $p->product_id,
                    'size1' => $p->size1,
                    'item_no' => $p->item_no
                ];
            })
        ]);

        // Add debug logging
        \Log::info('Category Page Debug', [
            'slug' => $slug,
            'category_id' => $mainCategory->family_category_id,
            'product_count' => $products->count(),
            'template' => $page->template
        ]);

        if ($page->template === 'welded_wire') {
            // Group by gauge first (size3)
            $meshSize_products = $products->map(function($product) {
                $product->color_variants = collect([
                    $product->color => [
                        'color' => $product->color,
                        'item_no' => $product->item_no,
                        'size2' => $product->size2,
                        'weight' => $product->weight,
                        'product_id' => $product->product_id
                    ]
                ]);
                $product->available_colors = collect([$product->color]);
                return $product;
            });

            return view('category-page', [
                'page' => $page,
                'mainCategory' => $mainCategory,
                'meshSize_products' => $meshSize_products,
                'isWeldedWire' => true
            ]);
        } elseif ($page->template === 'razor_wire') {
            // Add debug logging for razor wire products
            \Log::info('Razor Wire Products Debug', [
                'total_products' => $products->count(),
                'products' => $products->pluck('size1', 'item_no')->toArray()
            ]);

            // Filter 18" coil products for the main table
            $mainTableProducts = $products->filter(function($product) {
                return str_contains($product->size1, '18 in. Coil x 33 Loop');
            })->sortBy(function($product) {
                // Sort by quantity range (1-9 first, then 10-39, then 40 & up)
                if (str_contains($product->size1, '1-9')) return 1;
                if (str_contains($product->size1, '10-39')) return 2;
                if (str_contains($product->size1, '40')) return 3;
                return 4;
            });

            // Get other products for bottom boxes
            $otherProducts = $products->filter(function($product) {
                return !str_contains($product->size1, '18 in. Coil x 33 Loop');
            });

            // Add debug logging for filtered products
            \Log::info('Filtered Razor Wire Products Debug', [
                'main_table_products' => $mainTableProducts->pluck('size1', 'item_no')->toArray(),
                'other_products' => $otherProducts->pluck('size1', 'item_no')->toArray()
            ]);

            // Get quantity limits for each product
            $quantityLimits = $mainTableProducts->mapWithKeys(function($product) {
                $limit = 0;
                if (str_contains($product->size1, '1-9')) $limit = 9;
                elseif (str_contains($product->size1, '10-39')) $limit = 39;
                elseif (str_contains($product->size1, '40')) $limit = 999; // No practical upper limit
                
                return [$product->product_id => $limit];
            });

            return view('category-page', [
                'page' => $page,
                'mainCategory' => $mainCategory,
                'mainTableProducts' => $mainTableProducts,
                'otherProducts' => $otherProducts,
                'quantityLimits' => $quantityLimits,
                'isRazorWire' => true
            ]);
        } else {
            // Standard template logic
            $groups = [];
            $styleGroups = $products->whereNotNull('style')->groupBy('style');
            
            foreach ($styleGroups as $style => $styleProducts) {
                $group = [
                    'title' => $style ?: 'Other',
                    'image' => $styleProducts->first()->large_image ?? null,
                    'subgroups' => []
                ];

                // Group by speciality within style
                $specialityGroups = $styleProducts->whereNotNull('speciality')->groupBy('speciality');
                
                foreach ($specialityGroups as $speciality => $specialityProducts) {
                    // Group same products with different colors within each speciality
                    $uniqueProducts = $specialityProducts->groupBy(function($product) {
                        return $product->style . '-' . $product->speciality . '-' . $product->size1 . '-' . $product->size2;
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
                        'title' => $speciality ?: 'Other',
                        'products' => $uniqueProducts
                    ];
                }

                // Handle products without speciality
                $nospecialityProducts = $styleProducts->whereNull('speciality');
                if ($nospecialityProducts->isNotEmpty()) {
                    $uniqueProducts = $nospecialityProducts->groupBy(function($product) {
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

            // If no style groups, show all products grouped by speciality
            if (empty($groups)) {
                $specialityGroups = $products->whereNotNull('speciality')->groupBy('speciality');
                
                if ($specialityGroups->isNotEmpty()) {
                    $mainGroup = [
                        'title' => $mainCategory->family_category_name,
                        'image' => $products->first()->large_image ?? null,
                        'subgroups' => []
                    ];

                    foreach ($specialityGroups as $speciality => $specialityProducts) {
                        $uniqueProducts = $specialityProducts->groupBy(function($product) {
                            return $product->speciality . '-' . $product->size1 . '-' . $product->size2;
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
                            'title' => $speciality ?: 'Other',
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
}

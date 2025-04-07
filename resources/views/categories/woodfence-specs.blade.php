@extends('layouts.main')

@section('content')
<div class="container">
    @php
        // Define category-specific variables
        $categoryId = isset($category['id']) ? $category['id'] : 0;
        $categoryName = isset($category['cat_name']) ? $category['cat_name'] : 'Wood Fence';
        $isSpacedPicket = ($categoryId == 6);
        $isBoardOnBoard = ($categoryId == 7);
        $spacing = isset($spacing) ? $spacing : '';
    @endphp
    
    <div class="row">
        <div class="col-md-12">
            {{-- <h1 class="text-center mb-4">Wood Fence Specifications</h1>      --}}

    @if($isSpacedPicket)
        <x-woodfence.spaced-picket :styleGroups="$styleGroups" :category="$category" />
    @elseif($isBoardOnBoard)
        <x-woodfence.board-on-board :styleGroups="$styleGroups" :category="$category" />
    @elseif($groupBy === 'style')
        <h3 class="text-center mt-4 mb-4">Wood Fence Specifications</h3>
        
        @php
            // Define the preferred order for styles
            $styleOrder = ['Straight On Top', 'Concave', 'Convex'];
            
            // Define the preferred order for specialities within each style
            $specialityOrderMap = [
                'Straight On Top' => ['Slant Ear', 'Flat Picket', 'Gothic Point', 'French Gothic'],
                'Concave' => ['Slant Ear', 'Flat Picket', 'Gothic Point', 'French Gothic'],
                'Convex' => ['Slant Ear', 'Flat Picket', 'Gothic Point', 'French Gothic']
            ];
        @endphp
        
        @foreach ($styleOrder as $styleName)
            @php
                // Find the style group if it exists
                $styleGroup = null;
                foreach ($styleGroups as $group) {
                    if ($group['style'] === $styleName) {
                        $styleGroup = $group;
                        break;
                    }
                }
                
                // Skip if style doesn't exist
                if (!$styleGroup) continue;
                
                // Filter out Dog Ear, Flat Top, Knob Top, and Solid Top specialities
                // Also filter out products that don't have web_enabled set to true
                $filteredProducts = $styleGroup['combos']->filter(function($product) {
                    // Base filtering for all styles
                    return !in_array($product['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top', 'Solid Top']) && 
                           isset($product['web_enabled']) && $product['web_enabled'] == 1;
                });
                
                // Skip if no products after filtering
                if ($filteredProducts->isEmpty()) continue;
                
                // Group filtered products by speciality
                $filteredProductsBySpeciality = [];
                foreach ($filteredProducts as $product) {
                    $speciality = $product['speciality'] ?? 'Standard';
                    if (!isset($filteredProductsBySpeciality[$speciality])) {
                        $filteredProductsBySpeciality[$speciality] = [];
                    }
                    $filteredProductsBySpeciality[$speciality][] = $product;
                }
            @endphp
            
            <h2 class="section-title mt-5 mb-4" style="background-color: #000; color: #fff; padding: 10px; text-align: center; text-transform: uppercase;">{{ $styleGroup['style'] }}</h2>
            <div class="row">
                @foreach ($filteredProductsBySpeciality as $specialityName => $products)
                    <div class="col-md-4 mb-4">
                        <x-woodfence.specialty-card 
                            :styleGroup="$styleGroup" 
                            :specialityName="$specialityName" 
                            :products="$products"
                        />
                    </div>
                @endforeach
            </div>
        @endforeach
    @elseif($groupBy === 'speciality')
        <div class="row">
            @foreach ($specialityGroups as $specialityGroup)
                @php
                    // Skip Dog Ear, Flat Top, Knob Top, and Solid Top speciality groups
                    if (in_array($specialityGroup['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top', 'Solid Top'])) continue;
                    
                    // Filter out products that don't have web_enabled set to true
                    // For Straight On Top, hide Flat Picket
                    // For Concave and Convex, hide Slant Ear
                    $filteredProducts = $specialityGroup['products']->filter(function($product) use ($specialityGroup, $isSpacedPicket, $isBoardOnBoard) {
                        // Base filtering for all products
                        $baseFilter = isset($product['web_enabled']) && $product['web_enabled'] == 1;
                        
                        // Get the style from the product
                        $style = $product['style'] ?? '';
                        
                        // Apply style-specific filtering only for categories 6 and 7
                        if ($isSpacedPicket || $isBoardOnBoard) {
                            // Style-specific filtering
                            if ($style === 'Straight On Top') {
                                // For Straight On Top, hide Flat Picket
                                return $baseFilter && $specialityGroup['speciality'] !== 'Flat Picket';
                            } elseif (in_array($style, ['Concave', 'Convex'])) {
                                // For Concave and Convex, hide Slant Ear
                                return $baseFilter && $specialityGroup['speciality'] !== 'Slant Ear';
                            }
                        }
                        
                        return $baseFilter;
                    });
                    
                    // Skip if no products after filtering
                    if ($filteredProducts->isEmpty()) continue;
                @endphp
                
                <div class="col-md-4 mb-4">
                    <div class="card product-card shadow-sm h-100">
                        <div class="card-header bg-dark text-white text-center py-1">
                            <h5 class="my-0 fs-6">{{ $specialityGroup['speciality'] }}</h5>
                        </div>
                        @php
                            $product = $filteredProducts->first();
                        @endphp
                        <div class="card-body p-2 text-center">
                            <div class="product-image mb-2">
                                <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                    <img src="{{ $product['general_image'] }}"
                                        alt="{{ $specialityGroup['speciality'] }}" 
                                        class="img-fluid rounded"
                                        style="max-height: 135px !important; max-width: 100%;">
                                </a>
                            </div>
                            <div class="product-details small">
                                <p class="mb-1"><strong>Section Top Style:</strong> {{ $product['style'] }}</p>
                                <p class="mb-1"><strong>Heights:</strong> 6ft</p>
                                <p class="mb-1"><strong>Picket Style:</strong> {{ $specialityGroup['speciality'] }}</p>
                                @if(isset($product['spacing']) && !empty($product['spacing']))
                                    <p class="mb-1"><strong>Spacing:</strong> {{ $product['spacing'] }}</p>
                                @endif
                                @if(isset($product['material']) && !empty($product['material']))
                                    <p class="mb-1"><strong>Material:</strong> {{ $product['material'] }}</p>
                                @endif
                                @if(isset($product['price']) && $product['price'])
                                    <p class="mb-2"><strong>6ft Price:</strong> ${{ number_format($product['price'], 2) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center">
                            <a href="{{ route('product.show', ['id' => $product['product_id']]) }}" class="btn btn-sm btn-brown">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                @php
                    // Skip products with Dog Ear, Flat Top, Knob Top, and Solid Top speciality
                    if (in_array($product['speciality'] ?? '', ['Dog Ear', 'Flat Top', 'Knob Top', 'Solid Top'])) continue;
                    
                    // Only show products with ID 4 or 5
                    if (!in_array($product['product_id'], [4, 5])) continue;
                    
                    // Filter out products that don't have web_enabled set to true
                    // For Straight On Top, hide Flat Picket
                    // For Concave and Convex, hide Slant Ear
                    $baseFilter = isset($product['web_enabled']) && $product['web_enabled'] == 1;
                    
                    // Get the style from the product
                    $style = $product['style'] ?? '';
                    
                    // Apply style-specific filtering only for categories 6 and 7
                    if ($isSpacedPicket || $isBoardOnBoard) {
                        // Style-specific filtering
                        if ($style === 'Straight On Top') {
                            // For Straight On Top, hide Flat Picket
                            if ($product['speciality'] === 'Flat Picket') continue;
                        } elseif (in_array($style, ['Concave', 'Convex'])) {
                            // For Concave and Convex, hide Slant Ear
                            if ($product['speciality'] === 'Slant Ear') continue;
                        }
                    }
                    
                    // Skip if no products after filtering
                    if (!$baseFilter) continue;
                @endphp
                
                <div class="col-md-6 mb-4">
                    <div class="card product-card shadow-sm h-100">
                        <div class="card-header text-center py-2">
                            <h5 class="my-0">{{ $product['product_name'] ?? 'Tongue & Groove Fence - 100% Cedar' }}</h5>
                            <small>(Click image to purchase)</small>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="text-center">
                                        <h6>{{ $product['product_id'] == 4 ? 'Diagonal Lattice Top' : 'Square Lattice Top' }}</h6>
                                        <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                            <img src="{{ $product['general_image'] }}"
                                                alt="{{ $product['product_name'] ?? 'Tongue & Groove Fence' }}" 
                                                class="img-fluid rounded"
                                                style="max-height: 150px; max-width: 100%;">
                                        </a>
                                        <div class="product-details mt-2 p-2" style="background-color: #f5f5dc;">
                                            <p class="mb-1"><strong>Section Top Style:</strong> Straight</p>
                                            <p class="mb-1"><strong>Heights:</strong> 6ft</p>
                                            <p class="mb-1"><strong>Picket Style:</strong> Tongue & Groove</p>
                                            <p class="mb-1"><strong>Spacing:</strong> Solid</p>
                                            <p class="mb-1"><strong>6ft Price:</strong> $290.00</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="text-center">
                                        <h6>{{ $product['product_id'] == 4 ? 'Solid Top' : 'Diamond Top' }}</h6>
                                        <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                            <img src="{{ $product['general_image'] }}"
                                                alt="{{ $product['product_name'] ?? 'Tongue & Groove Fence' }}" 
                                                class="img-fluid rounded"
                                                style="max-height: 150px; max-width: 100%;">
                                        </a>
                                        <div class="product-details mt-2 p-2" style="background-color: #f5f5dc;">
                                            <p class="mb-1"><strong>Section Top Style:</strong> Straight</p>
                                            <p class="mb-1"><strong>Heights:</strong> 6ft</p>
                                            <p class="mb-1"><strong>Picket Style:</strong> Tongue & Groove</p>
                                            <p class="mb-1"><strong>Spacing:</strong> Solid</p>
                                            <p class="mb-2"><strong>6ft Price:</strong> {{ $product['product_id'] == 5 ? 'Discontinued' : '$290.00' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="small text-center mt-2">
                                * All sketches, images, drawings and pictures are intended to give the viewer a sense of the general style of the item. They are not to scale and should not be used for specific details or measurements.
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Equal height for cards in the same row
        function equalizeCardHeights() {
            $('.row').each(function() {
                let maxHeight = 0;
                $('.card', this).each(function() {
                    $(this).css('height', '');
                    maxHeight = Math.max(maxHeight, $(this).outerHeight());
                });
                $('.card', this).outerHeight(maxHeight);
            });
        }
        
        $(window).on('load resize', function() {
            equalizeCardHeights();
        });
    });
</script>
@endsection
@section('styles')
<style>
    .product-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .product-card .product-image img {
        display: block;
        margin: 0 auto;
        max-height: 150px;
    }

    .product-card .product-details {
        text-align: center;
    }

    .product-card .card-footer {
        text-align: center;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
</style>
@endsection
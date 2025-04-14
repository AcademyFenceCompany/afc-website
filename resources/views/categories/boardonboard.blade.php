@extends('layouts.main')

@section('content')
<div class="container">
    <h3 class="text-center mt-4 mb-4">Wood Fence Specifications - Board on Board</h3>
    
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-brown text-white py-1">
                    <h6 class="mb-0">Available Spacings</h6>
                </div>
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap justify-content-center">
                        @foreach($spacings as $spacingOption)
                            <a href="{{ route('board-on-board', ['spacing' => $spacingOption]) }}" 
                               class="btn btn-sm {{ $currentSpacing == $spacingOption ? 'btn-brown' : 'btn-outline-secondary' }} m-1">
                                {{ $spacingOption }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($styleOrder as $styleName)
        @if (isset($productsByStyle[$styleName]) && count(array_filter($productsByStyle[$styleName], function($products) { return count($products) > 0; })) > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-title py-2" style="background-color: #000; color: #fff; text-align: center; text-transform: uppercase; font-weight: bold; font-size: 1.2rem;">{{ $styleName }}</div>
                </div>
            </div>

            <div class="row mb-5">
                @php
                    // Define the speciality order for this style
                    $specialityOrder = [
                        'Straight On Top' => ['Slant Ear', 'Gothic Point', 'French Gothic'],
                        'Concave' => ['Flat picket', 'Gothic Point', 'French Gothic'],
                        'Convex' => ['Flat picket', 'Gothic Point', 'French Gothic']
                    ][$styleName] ?? array_keys($productsByStyle[$styleName]);
                @endphp
                
                @foreach ($specialityOrder as $specialityName)
                    @if (isset($productsByStyle[$styleName][$specialityName]) && count($productsByStyle[$styleName][$specialityName]) > 0)
                        @php
                            // Get a sample product from this style and speciality group
                            $sampleProduct = $productsByStyle[$styleName][$specialityName][0];
                            
                            // Get product ID from the map or directly from the product
                            $productId = $sampleProduct->id ?? null;
                            
                            // Get image from product data or use default
                            $image = isset($productData[$productId]) ? $productData[$productId]['image'] : url('storage/products/default.png');
                            
                            // Get product link from mapping if available
                            $productLink = isset($productIdMap[$styleName][$specialityName]) ? $productIdMap[$styleName][$specialityName] : null;
                            $linkId = null;
                            $linkType = null;
                            
                            if ($productLink) {
                                $parts = explode('/', $productLink);
                                if (count($parts) == 2) {
                                    $linkType = $parts[0];
                                    $linkId = $parts[1];
                                }
                            } else if ($productId) {
                                // If no link in map, use the product ID directly
                                $linkType = 'product';
                                $linkId = $productId;
                            }
                        @endphp
                        
                        <div class="col-md-4 mb-4">
                            <div class="h-100 d-flex flex-column">
                                <div class="speciality-header py-2" style="background-color: #8B2703; color: #fff; text-align: center; font-weight: bold; text-transform: uppercase;">{{ $specialityName }}</div>
                                
                                <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none;">
                                    <img src="{{ $image }}" alt="{{ $specialityName }}" style="max-height: 135px; max-width: 100%;">
                                </div>
                                
                                <div class="flex-grow-1" style="padding: 1rem; border: 1px solid #ddd; border-top: none; text-align: center;">
                                    <div class="product-details small">
                                        <p class="mb-1"><strong>Section Top Style:</strong> {{ $styleName }}</p>
                                        <p class="mb-1"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                        <p class="mb-1"><strong>Picket Style:</strong> {{ $specialityName }}</p>
                                        <p class="mb-1"><strong>Spacing:</strong> {{ $currentSpacing ?? 'default' }}</p>
                                    </div>
                                    <div class="mt-3">
                                        @if ($linkType && $linkId)
                                            @if ($linkType === 'product')
                                                <a href="{{ route('product.show', ['id' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                                            @elseif ($linkType === 'category')
                                                <a href="{{ route('category.show', ['slug' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                                            @endif
                                        @else
                                            <a href="#" class="btn btn-sm btn-brown">View Details</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    @endforeach
</div>

<style>
    .btn-brown {
        background-color: #8B2703;
        color: white;
        border: none;
    }
    .btn-brown:hover {
        background-color: #6e1f02;
        color: white;
    }
</style>
@endsection
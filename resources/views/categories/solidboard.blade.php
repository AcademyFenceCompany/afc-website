@extends('layouts.main')

@section('content')
<div class="container">
    <h3 class="text-center mt-4 mb-4">Wood Fence Specifications - Solid Board</h3>

    @foreach ($styleOrder as $styleName)
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
                    'Concave' => ['Flat Picket', 'Gothic Point', 'French Gothic'],
                    'Convex' => ['Flat Picket', 'Gothic Point', 'French Gothic']
                ][$styleName] ?? [];
            @endphp
            
            @foreach ($specialityOrder as $specialityName)
                @php
                    // Get product ID from the map
                    $productLink = $productIdMap[$styleName][$specialityName] ?? null;
                    $productId = null;
                    
                    if ($productLink) {
                        $parts = explode('/', $productLink);
                        if (count($parts) == 2 && $parts[0] === 'product') {
                            $productId = $parts[1];
                        }
                    }
                    
                    // Get image from product map or use default
                    $image = $productId && isset($productMap[$productId]) ? $productMap[$productId]['image'] : $defaultImage;
                @endphp
                
                <div class="col-md-4">
                    <div class="mb-4">
                        <div class="speciality-header py-2" style="background-color: #8B2703; color: #fff; text-align: center; font-weight: bold; text-transform: uppercase;">{{ $specialityName }}</div>
                        
                        <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none;">
                            <img src="{{ $image }}" alt="{{ $specialityName }}" style="max-height: 135px; max-width: 100%;">
                        </div>
                        
                        <div style="padding: 1rem; border: 1px solid #ddd; border-top: none; text-align: center;">
                            <div class="product-details small">
                                <p class="mb-1"><strong>Section Top Style:</strong> {{ $styleName }}</p>
                                <p class="mb-1"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                                <p class="mb-1"><strong>Picket Style:</strong> {{ $specialityName }}</p>
                                <p class="mb-1"><strong>Spacing:</strong> No Spacing</p>
                                <p class="mb-1"><strong>Pickets Per Section:</strong> 27</p>
                            </div>
                            <div class="mt-3">
                                @if (isset($productIdMap[$styleName][$specialityName]))
                                    @php
                                        $link = $productIdMap[$styleName][$specialityName];
                                        $linkParts = explode('/', $link);
                                        $linkType = $linkParts[0];
                                        $linkId = $linkParts[1];
                                    @endphp
                                    
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
            @endforeach
        </div>
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

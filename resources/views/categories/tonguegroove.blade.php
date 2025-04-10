@extends('layouts.main')

@section('title', 'Tongue & Groove Fence')

@section('styles')
<style>
    .page-title {
        text-align: center;
        margin-bottom: 30px;
    }
    .main-header {
        background-color: #000;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .speciality-header {
        background-color: #8B4513;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 0;
        font-weight: normal;
    }
    .product-image {
        width: 100%;
        max-width: 250px;
        height: auto;
        display: block;
        margin: 0 auto;
        padding: 15px 0;
    }
    .product-details {
        padding: 15px;
        text-align: left;
    }
    .detail-row {
        margin-bottom: 5px;
    }
    .view-details-btn {
        background-color: #8B4513;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 3px;
        cursor: pointer;
    }
    .product-card {
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
    .bg-brown {
        background-color: #8B4513 !important;
    }
    .text-brown {
        color: #8B4513 !important;
    }
    .btn-brown {
        background-color: #8B4513 !important;
        color: white !important;
        border-color: #8B4513 !important;
    }
    .btn-brown:hover {
        background-color: #6B3100 !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="main-header">
                <h4 class="mb-0">Wood Fence Specifications - Tongue & Groove</h4>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($specialityOrder as $index => $specialityName)
            @if (isset($productsBySpeciality[$specialityName]) && count($productsBySpeciality[$specialityName]) > 0)
                <div class="col-md-4 mb-4">
                    <div class="h-100 d-flex flex-column">
                        <div class="speciality-header py-2" style="background-color: #8B2703; color: #fff; text-align: center; font-weight: bold; text-transform: uppercase;">{{ $specialityName }}</div>
                        
                        @php
                            $product = $productsBySpeciality[$specialityName][0]; // Take just the first product
                            $productId = $product->id;
                            $imagePath = isset($productData[$productId]) ? $productData[$productId]['image'] : $defaultImage;
                            $price = isset($productData[$productId]) && isset($productData[$productId]['price']) ? $productData[$productId]['price'] : 'N/A';
                            
                            // Determine if we have a link to a product page
                            $linkType = null;
                            $linkId = null;
                            
                            if (isset($product->products_id) && $product->products_id > 0) {
                                $linkType = 'product';
                                $linkId = $product->products_id;
                            } elseif (isset($product->id) && $product->id > 0) {
                                $linkType = 'product';
                                $linkId = $product->id;
                            }
                        @endphp
                        
                        <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none; text-align: center !important;">
                            <img src="{{ $imagePath }}" alt="{{ $specialityName }}" style="max-height: 135px; max-width: 100%;">
                        </div>
                        
                        <div class="flex-grow-1" style="padding: 1rem; border: 1px solid #ddd; border-top: none; text-align: center;">
                            <div class="product-details small">
                                <p class="mb-1"><strong>Section Top Style:</strong> Straight On Top</p>
                                <p class="mb-1"><strong>Heights:</strong> 4ft, 5ft, 6ft</p>
                                <p class="mb-1"><strong>Picket Style:</strong> Tongue & Groove</p>
                                <p class="mb-1"><strong>Spacing:</strong> Solid</p>
                                <p class="mb-1"><strong>Price:</strong> ${{ number_format($price, 2) }}</p>
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
</div>
@endsection

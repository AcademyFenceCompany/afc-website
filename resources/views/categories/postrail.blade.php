@extends('layouts.main')

@section('title', 'Post and Rail Fence')

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
    .style-header {
        background-color: #8B2703;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 0;
        font-weight: bold;
        text-transform: uppercase;
    }
    .product-image {
        max-height: 135px;
        max-width: 100%;
    }
    .product-details {
        padding: 15px;
        text-align: left;
    }
    .detail-row {
        margin-bottom: 5px;
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
                <h4 class="mb-0">Wood Fence Specifications - Post and Rail</h4>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($styleOrder as $styleName)
            @if (isset($productsByStyle[$styleName]) && count($productsByStyle[$styleName]) > 0)
                <div class="col-md-6 mb-4">
                    <div class="h-100 d-flex flex-column">
                        <div class="style-header py-2">{{ $styleName }}</div>
                        
                        @php
                            $product = $productsByStyle[$styleName][0]; // Take just the first product
                            $productId = $product->id;
                            $imagePath = isset($productData[$productId]) ? $productData[$productId]['image'] : $defaultImage;
                            $railCount = isset($productData[$productId]) ? $productData[$productId]['rails'] : 'Available in 2 or 3 rail';
                            $endType = isset($productData[$productId]) ? $productData[$productId]['end_type'] : '';
                        @endphp
                        
                        <div class="text-center py-3" style="border: 1px solid #ddd; border-top: none; text-align: center !important;">
                            <img src="{{ $imagePath }}" alt="{{ $styleName }}" style="max-height: 135px; max-width: 100%;">
                        </div>
                        <div class="flex-grow-1" style="padding: 1rem; border: 1px solid #ddd; border-top: none; text-align: center;">
                            <div class="product-details text-center">
                                @if ($styleName == 'Round Rail')
                                    <p class="mb-1"><strong>Cedar Round Post & Rail</strong></p>
                                @else
                                    <p class="mb-1"><strong>Split Rail Post and Rail</strong></p>
                                @endif
                                
                                @if (!empty($endType))
                                    <p class="mb-1">{{ $endType }}</p>
                                @endif
                                
                                <p class="mb-1">{{ $railCount }}</p>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('postrail.style', ['style' => strtolower(str_replace(' ', '-', $styleName))]) }}" class="btn btn-sm btn-brown">View Products</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection

@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{-- <h1 class="text-center mb-4">Wood Fence Specifications</h1>      --}}

    @if($groupBy === 'style')
        @foreach ($styleGroups as $styleGroup)
            <!-- Skip styles that don't have any products after filtering -->
            @php
                // Filter out Dog Ear, Flat Top, and Knob Top specialities
                $filteredProducts = $styleGroup['combos']->filter(function($product) {
                    return !in_array($product['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top']);
                });
                
                if ($filteredProducts->isEmpty()) continue;
            @endphp
            
            <div class="mb-4">
                <div class="rounded" style="background-color: #000;">
                    <h2 class="text-white text-center py-2 my-0 text-uppercase fs-4">{{ $styleGroup['style'] }}</h2>
                </div>
                
                <div class="row mt-3">
                    @php
                        // Group by speciality within style
                        $specialityProducts = $filteredProducts->groupBy('speciality');
                    @endphp
                    
                    @foreach($specialityProducts as $speciality => $products)
                        @if(!empty($speciality))
                            <div class="col-md-4 mb-4">
                                <div class="card product-card shadow-sm h-100">
                                    <div class="card-header bg-secondary text-white text-center py-1">
                                        <h5 class="my-0 fs-6">{{ $speciality }}</h5>
                                    </div>
                                    @php
                                        $product = $products->first();
                                    @endphp
                                    <div class="card-body p-2 text-center">
                                        <div class="product-image mb-2">
                                            <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                                <img src="{{ $product['general_image'] }}"
                                                    alt="{{ $styleGroup['style'] }} - {{ $speciality }}" 
                                                    class="img-fluid rounded"
                                                    style="max-height: 150px; max-width: 100%;">
                                            </a>
                                        </div>
                                        <div class="product-details small">
                                            <p class="mb-1"><strong>Section Top Style:</strong> {{ $styleGroup['style'] }}</p>
                                            <p class="mb-1"><strong>Heights:</strong> 6ft</p>
                                            <p class="mb-1"><strong>Picket Style:</strong> {{ $speciality }}</p>
                                            @if(isset($product['spacing']) && !empty($product['spacing']))
                                                <p class="mb-1"><strong>Spacing:</strong> {{ $product['spacing'] }}</p>
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
                        @endif
                    @endforeach
                    
                    @if(isset($groupedNoSpeciality) && $groupedNoSpeciality->count() > 0)
                        @foreach ($groupedNoSpeciality as $material => $products)
                            @php
                                $product = $products->first();
                            @endphp
                            <div class="col-md-4 mb-4">
                                <div class="card product-card shadow-sm h-100">
                                    <div class="card-header bg-secondary text-white text-center py-1">
                                        <h5 class="my-0 fs-6">{{ $material }}</h5>
                                    </div>
                                    <div class="card-body p-2 text-center">
                                        <div class="product-image mb-2">
                                            <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                                <img src="{{ $product['general_image'] }}"
                                                    alt="{{ $styleGroup['style'] }} - {{ $material }}" 
                                                    class="img-fluid rounded"
                                                    style="max-height: 150px; max-width: 100%;">
                                            </a>
                                        </div>
                                        <div class="product-details small">
                                            <p class="mb-1"><strong>Section Top Style:</strong> {{ $styleGroup['style'] }}</p>
                                            <p class="mb-1"><strong>Heights:</strong> 6ft</p>
                                            <p class="mb-1"><strong>Material:</strong> {{ $material }}</p>
                                            @if(isset($product['spacing']) && !empty($product['spacing']))
                                                <p class="mb-1"><strong>Spacing:</strong> {{ $product['spacing'] }}</p>
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
                    @endif
                </div>
            </div>
        @endforeach
    @elseif($groupBy === 'speciality')
        <div class="row">
            @foreach ($specialityGroups as $specialityGroup)
                @php
                    // Skip Dog Ear, Flat Top, and Knob Top speciality groups
                    if (in_array($specialityGroup['speciality'], ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                @endphp
                
                <div class="col-md-4 mb-4">
                    <div class="card product-card shadow-sm h-100">
                        <div class="card-header bg-dark text-white text-center py-1">
                            <h5 class="my-0 fs-6">{{ $specialityGroup['speciality'] }}</h5>
                        </div>
                        @php
                            $product = $specialityGroup['products']->first();
                        @endphp
                        <div class="card-body p-2 text-center">
                            <div class="product-image mb-2">
                                <a href="{{ route('product.show', ['id' => $product['product_id']]) }}">
                                    <img src="{{ $product['general_image'] }}"
                                        alt="{{ $specialityGroup['speciality'] }}" 
                                        class="img-fluid rounded"
                                        style="max-height: 150px; max-width: 100%;">
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
                    // Skip products with Dog Ear, Flat Top, or Knob Top speciality
                    if (in_array($product['speciality'] ?? '', ['Dog Ear', 'Flat Top', 'Knob Top'])) continue;
                    
                    // Only show products with ID 4 or 5
                    if (!in_array($product['product_id'], [4, 5])) continue;
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
                                            <p class="mb-1"><strong>6ft Price:</strong> {{ $product['product_id'] == 5 ? 'Discontinued' : '$290.00' }}</p>
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

@props([
    'styleGroup',
    'specialityName',
    'products',
    'isSpacedPicket' => false,
    'isBoardOnBoard' => false,
    'productIdMap' => []
])

@php
    // Get the first product if available
    $firstProduct = !empty($products) ? $products[0] : null;
    
    // Define product image - use placeholder if no product or image
    $productImage = $firstProduct && isset($firstProduct['general_image']) && !empty($firstProduct['general_image']) 
        ? $firstProduct['general_image']
        : url('storage/products/default.png');
    
    // Get heights, default to a standard set if not found
    $heights = $firstProduct && isset($firstProduct['heights']) && !empty($firstProduct['heights']) 
        ? $firstProduct['heights'] 
        : '3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft';
    
    // Spacing information - No Spacing for category 7
    $spacing = $isBoardOnBoard ? 'No Spacing' : ($firstProduct && isset($firstProduct['spacing']) ? $firstProduct['spacing'] : 'Variable');
    
    // Pickets per section - specific values for each category
    if ($isSpacedPicket) {
        $picketsPerSection = '17 (16 + 1 Cover Picket)';
    } elseif ($isBoardOnBoard) {
        $picketsPerSection = '27';
    } else {
        $picketsPerSection = $firstProduct && isset($firstProduct['pickets_per_section']) ? $firstProduct['pickets_per_section'] : '';
    }
@endphp

<div class="card product-card shadow-sm h-100">
    <div class="card-header bg-dark text-white text-center py-1">
        <h5 class="my-0 fs-6">{{ $specialityName }}</h5>
    </div>
    
    @if (!empty($products))
        <div class="card-body p-2 text-center">
            <div class="product-image mb-2">
                <img src="{{ $productImage }}" 
                    alt="{{ $styleGroup['style'] }} - {{ $specialityName }}" 
                    class="img-fluid rounded"
                    style="max-height: 135px !important; max-width: 100%;">
            </div>
            <div class="product-details small">
                <p class="mb-1"><strong>Section Top Style:</strong> {{ $firstProduct['style'] ?? $styleGroup['style'] }}</p>
                <p class="mb-1"><strong>Heights:</strong> {{ $heights }}</p>
                <p class="mb-1"><strong>Picket Style:</strong> {{ $specialityName }}</p>
                <p class="mb-1"><strong>Spacing:</strong> {{ $spacing }}</p>
                <p class="mb-1"><strong>Pickets Per Section:</strong> {{ $picketsPerSection }}</p>
            </div>
        </div>
        
        @if (!$isBoardOnBoard && isset($firstProduct['product_id']))
            <div class="card-footer bg-white border-top-0 text-center">
                <a href="{{ route('product.show', ['id' => $firstProduct['product_id']]) }}" class="btn btn-sm btn-brown">View Details</a>
            </div>
        @elseif ($isBoardOnBoard && isset($productIdMap[$styleGroup['style']][$specialityName]))
            <div class="card-footer bg-white border-top-0 text-center">
                @php
                    $productLink = $productIdMap[$styleGroup['style']][$specialityName];
                    $linkParts = explode('/', $productLink);
                    $linkType = $linkParts[0];
                    $linkId = $linkParts[1];
                @endphp
                
                @if ($linkType === 'product')
                    <a href="{{ route('product.show', ['id' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                @elseif ($linkType === 'category')
                    <a href="{{ route('category.show', ['slug' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                @endif
            </div>
        @endif
    @else
        <!-- Display empty placeholder with default values -->
        <div class="card-body p-2 text-center">
            <div class="product-image mb-2">
                <img src="{{ url('storage/products/default.png') }}" 
                    alt="{{ $specialityName }}" 
                    class="img-fluid rounded"
                    style="max-height: 135px !important; max-width: 100%;">
            </div>
            <div class="product-details small">
                <p class="mb-1"><strong>Section Top Style:</strong> {{ $styleGroup['style'] }}</p>
                <p class="mb-1"><strong>Heights:</strong> 3ft, 42in, 4ft, 5ft, 6ft, 7ft, 8ft</p>
                <p class="mb-1"><strong>Picket Style:</strong> {{ $specialityName }}</p>
                <p class="mb-1"><strong>Spacing:</strong> No Spacing</p>
                <p class="mb-1"><strong>Pickets Per Section:</strong> 27</p>
            </div>
        </div>
        
        @if ($isBoardOnBoard && isset($productIdMap[$styleGroup['style']][$specialityName]))
            <div class="card-footer bg-white border-top-0 text-center">
                @php
                    $productLink = $productIdMap[$styleGroup['style']][$specialityName];
                    $linkParts = explode('/', $productLink);
                    $linkType = $linkParts[0];
                    $linkId = $linkParts[1];
                @endphp
                
                @if ($linkType === 'product')
                    <a href="{{ route('product.show', ['id' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                @elseif ($linkType === 'category')
                    <a href="{{ route('category.show', ['slug' => $linkId]) }}" class="btn btn-sm btn-brown">View Details</a>
                @endif
            </div>
        @endif
    @endif
</div>

@extends('layouts.main')

@section('title', $pageTitle)

@section('styles')
<style>
    .main-header {
        background-color: #1a4d2e;
        color: white;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    
    .product-group {
        margin-bottom: 30px;
    }
    
    .product-group-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #1a4d2e;
        border-bottom: 2px solid #1a4d2e;
        padding-bottom: 10px;
    }
    
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        transition: transform 0.3s ease;
        background-color: #fff;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .product-image {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }
    
    .product-image img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    
    .product-info {
        padding: 15px;
    }
    
    .product-title {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }
    
    .product-code {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .product-price {
        font-weight: bold;
        color: #d9534f;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    
    .product-description {
        color: #333;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .add-to-cart-btn {
        width: auto;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .quantity-input {
        text-align: center;
        width: 60px;
        margin: 0 5px;
    }
    
    .quantity-btn {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        background-color: #f8f9fa;
    }
    
    .quantity-btn:hover {
        background-color: #e9ecef;
    }
    
    .system-selection {
        margin-bottom: 30px;
    }
    
    .system-selection-title {
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #fff;
        margin-left: 200px;
        background-color: #972525;
        padding: 8px 20px;
    }
    
    .system-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 85%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
    }
    
    .system-card.active {
        background-color: #e9ecef;
    }
    
    .system-name {
    font-weight: bold;
    margin-bottom: 0px;
    color: #333;
    font-size: 15px;
}
    
    .system-description {
        color: #555;
        font-size: 12px;
    }
    
    .system-image {
    width: 43%;
    min-width: 80px;
    margin-right: 6px;
    overflow: hidden;
}
    
    .bundle-info {
        flex: 1;
    }
    .system-image img {
    width: 100%;
    height: 100px;
}
    
    .current-system-info {
        margin-bottom: 30px;
    }
    
    /* New styles for bundle layout */
    .system-bundle {
        margin-bottom: 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .system-bundle-header {
        background-color: #972525;
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }
    
    .system-bundle-title {
        margin: 0;
        color: #fff;
        font-size: 1.25rem;
    }
    
    .system-bundle-subtitle {
        margin: 0;
        color: #fff;
        font-size: 1rem;
    }
    
    .system-bundle-content {
        display: flex;
        flex-direction: column;
        padding: 20px;
    }
    
    .bundle-image {
        width: 100%;
        max-width: 300px;
        margin: 0 auto 20px;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .bundle-image img {
        width: 100%;
        height: auto;
    }
    
    .product-category {
        margin-bottom: 25px;
    }
    
    .product-category-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 12px;
        padding-bottom: 5px;
        border-bottom: 2px solid #972525;
        color: #000;
    }
    
    .product-category-description {
        font-size: 0.85rem;
        color: #555;
        margin-bottom: 15px;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        border-left: 3px solid #1a4d2e;
    }
    
    .product-item {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 12px;
        background-color: #fff;
    }
    
    .product-item-header {
    display: flex
;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 8px;
}
    
    .product-item-title {
        font-weight: bold;
        font-size: 1rem;
    }
    
    .product-item-price {
        font-weight: bold;
        color: #d9534f;
    }
    
    .product-item-details {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 8px;
    }
    
    .product-item-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .size-select {
        margin-bottom: 0;
        display: inline-flex;
        align-items: center;
        margin-right: 10px;
    }
    
    .size-select label {
        white-space: nowrap;
        margin-right: 10px;
        margin-bottom: 0;
        font-size: 0.85rem;
    }
    
    .size-select select {
        width: auto;
        min-width: 120px;
    }
    
    .product-controls {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }
    
    .quantity-control {
        display: flex;
        align-items: center;
        margin-bottom: 0;
        margin-right: 10px;
    }
    
    .quantity-small {
        width: 80px;
    }
    
    .quantity-small .quantity-btn {
        width: 24px;
        height: 24px;
    }
    
    .quantity-small .quantity-input {
        width: 40px;
        height: 24px;
        padding: 0 5px;
        font-size: 0.85rem;
    }
    
    .total-price {
        font-weight: bold;
        color: #d9534f;
        margin-left: 35px;
    }
    
    .installation-options {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        font-size: 10px;
    }
    
    .installation-title {
        color: #fff !important;
        font-size: 14px;
        margin-bottom: 10px;
        font-weight: bold;
        background-color: #972525 !important;
        padding: 5px 5px;
    }
    
    installation-list {
    padding-left: 20px;
    font-size: 11px;
}
    
    .installation-steps {
        padding-left: 20px;
    }
    
    .system-info-box {
        background-color: #f8f9fa;
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 4px;
        border-left: 3px solid #972525;
        font-size: 0.85rem;
    }
    
    .system-info-text {
        margin-bottom: 6px;
        line-height: 1.4;
    }
    
    .system-info-text:last-child {
        margin-bottom: 0;
    }
    
    .system-info-highlight {
        font-weight: bold;
        color: #972525;
    }
    
    .system-type-badge {
        background-color: #972525;
        color: white;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 3px;
        display: inline-block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    @media (min-width: 768px) {
        .system-bundle-content {
            flex-direction: row;
        }
        
        .bundle-image {
            flex: 0 0 300px;
            margin: 0 20px 0 0;
        }
        
        .bundle-products {
            flex: 1;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="rounded bg-brown mb-2">
        <div class="system-bundle-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="heightDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Change Height
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="heightDropdown">
                        <li><a class="dropdown-item {{ $height == '4ft' ? 'active' : '' }}" href="{{ route('chainlink.height', ['height' => '4ft']) }}">4ft Height</a></li>
                        <li><a class="dropdown-item {{ $height == '5ft' ? 'active' : '' }}" href="{{ route('chainlink.height', ['height' => '5ft']) }}">5ft Height</a></li>
                        <li><a class="dropdown-item {{ $height == '6ft' ? 'active' : '' }}" href="{{ route('chainlink.height', ['height' => '6ft']) }}">6ft Height</a></li>
                    </ul>
                </div>
                <h4 class="system-bundle-title text-center flex-grow-1">{{ $height }} - Chain Link Fence Complete {{ $systems[$system]['name'] }}</h4>
            </div>
        </div>
    </div>
    
    <!-- System Selection -->
    <div class="system-selection mb-2">
        <div class="titles d-flex justify-content-evenly">
            {{-- <h2 class="system-selection-title mb-3" style="visibility: hidden;">Select System Type</h2>
            <h2 class="system-selection-title mb-3">Non-Climbable | Pool Code</h2> --}}
        </div>
        <!-- All systems in one row -->
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-3">
            <!-- Regular systems (1-3) -->
            @foreach($systems as $systemId => $systemInfo)
                @if($systemId <= 3)
                <div class="col">
                    <a href="{{ route('chainlink.height.system', ['height' => $height, 'system' => $systemId]) }}" 
                       class="text-decoration-none">
                        <div class="system-card p-2 rounded {{ $systemId == $system ? 'active' : '' }}">
                            <div class="system-image">
                                <img src="{{ $systemInfo['image'] }}" alt="{{ $height }} Chain Link Fence">
                            </div>
                            <div class="bundle-info">
                                <h3 class="system-name h5">{{ $systemInfo['name'] }}</h3>
                                <p class="system-description mb-0"><strong><span class="text-center">Frame:</span><br><span style="margin-left: 0">{{ $systemInfo['frame'] }}</span></strong></p>
                                <p class="system-description mb-0"><strong><span class="text-center">Wire:</span><br><span style="margin-left: 0">{{ $systemInfo['wire'] }}</span></strong></p>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
            
            <!-- Non-Climbable systems (4-5) -->
            @foreach($systems as $systemId => $systemInfo)
                @if($systemId >= 4)
                <div class="col">
                    <a href="{{ route('chainlink.height.system', ['height' => $height, 'system' => $systemId]) }}" 
                       class="text-decoration-none">
                        <div class="system-card p-2 rounded {{ $systemId == $system ? 'active' : '' }}">
                            <div class="system-image">
                                <img src="{{ $systemInfo['image'] }}" alt="{{ $height }} Chain Link Fence">
                            </div>
                            <div class="bundle-info">
                                <h3 class="system-name h5">{{ $systemInfo['name'] }} <img src="{{ url('storage/products/pcicon.jpg') }}" alt="Nonclimb" class="img-fluid" style="max-height: 20px; margin-right: 5px;"></h3>
                                <p class="system-description mb-0"><strong>Frame:<br>{{ $systemInfo['frame'] }}</strong></p>
                                <p class="system-description mb-0"><strong>Wire:<br>{{ $systemInfo['wire'] }}</strong></p>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <!-- Current System Bundle -->
    <div class="system-bundle">
        <!-- System Info Box -->
        <div class="system-info-box">
            <div class="row">
                <div class="col-12 col-md-6 p-2">
                    <p class="system-info-text">
                        Our complete fence systems include all necessary hardware for your installation. We simply need to know three things:
                        <span class="system-info-highlight">1) your total linear footage</span>,
                        <span class="system-info-highlight">2) the number of terminal posts</span>, and
                        <span class="system-info-highlight">3) the number of access gates</span>.
                    </p>
                    <p class="system-info-text">
                        All parts necessary to erect the fence are included in the price (except concrete). Alternatively, you can select individual parts from our complete line of posts, rail, pipe, fittings, hardware, hinges, latches, accessories and gates; all in stock and ready for pickup or shipping.
                    </p>
                </div>
                <div class="col-12 col-md-6 text-center">
                    <img src="{{ url('storage/categories/chainlinkdraw.jpg') }}" alt="Chain Link Fence Diagram" class="img-fluid" style="max-height: 180px;">
                </div>
            </div>
        </div>
        
        <div class="system-bundle-content">
            <!-- Bundle Image -->
            {{-- @dump($systems[$system]['image']) --}}
            <div class="bundle-image">
                <h4 class="text-center">{{ $height }} High-{{ $systems[$system]['name'] }}</h4>
                <img src="{{ $systems[$system]['image'] }}" alt="{{ $height }} Chain Link Fence System">
                
                <!-- Installation Options -->
                <div class="installation-options mt-4">
                    <h4 class="installation-title">
                        <a href="#" id="installation-toggle" class="installation-title text-decoration-none text-dark d-flex align-items-center" 
                           onclick="toggleInstallation(event)">
                            <span>Learn more about installations</span>
                            <i class="bi bi-chevron-down ms-2"></i>
                        </a>
                    </h4>
                    <div id="installation-content" class="collapse">
                        <ol class="installation-list">
                            <li>
                                <strong>Allow our professional fence technicians to do the work for you!!</strong> (New Jersey area) 
                                Use our simple quote sheet and send in your info by email or fax.
                            </li>
                            <li class="mt-2">
                                <strong>Install your {{ $height }} chain link system yourself.</strong> In order to simplify the process of figuring out what fence parts you need for your fencing project and to calculate the actual price, we offer the following simple method:
                                
                                <ol class="installation-steps mt-2">
                                    <li>Select the Academy chain link fence system {{ $height }} (five choices above)</li>
                                    <li>Determine the total linear footage of your fence measurements and multiply by the price per foot. This price includes the chain link mesh fabric, the top rail, line posts, and loop caps and tie wire ties.</li>
                                    <li>Determine how many terminal posts you need (this is any post where the fence starts and stops, including end, corner, and gate posts.) This price includes the post, and all the fittings (including tension bands, brace bands, rail ends, and caps). You may choose larger diameter terminal posts for the larger double drive gates.</li>
                                    <li>Choose the quantity and size of access gates. This price includes the gate, and all the hardware (including hinges, latches, gate caps, and drop bars for double gates). It does not include the gate posts, those would be counted as terminal posts.</li>
                                </ol>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            
            <!-- Bundle Products -->
            <div class="bundle-products">
                @if(count($productGroups) > 0)
                    @foreach($productGroups as $categoryKey => $group)
                        <div class="product-category">
                            <h3 class="product-category-title">{{ $group['title'] }} - {{ $systems[$system]['name'] }}</h3>
                            
                            @if($categoryKey == 'terminal_posts')
                               
                                @foreach($group['products'] as $product)
                                    <div class="product-item">
                                        <div class="product-item-header">
                                            <div class="product-item-title" style="margin-right: 8px">{{ $product->product_name }}-{{ $product->size }}</div>
                                            <div class="product-item-actions">
                                                <div class="product-controls">
                                                    <div class="quantity-control quantity-small">
                                                        <div class="quantity-btn quantity-minus" onclick="updateQuantity({{ $product->id }}, -1)"><i class="bi bi-dash"></i></div>
                                                        <input type="number" id="quantity-{{ $product->id }}" class="form-control quantity-input" value="1" min="1" onchange="updateTotalPrice({{ $product->id }})">
                                                        <div class="quantity-btn quantity-plus" onclick="updateQuantity({{ $product->id }}, 1)"><i class="bi bi-plus"></i></div>
                                                    </div>
                                                    <div class="total-price" id="total-price-{{ $product->id }}">${{ number_format($product->price, 2) }}</div>
                                                    <button class="btn btn-danger btn-sm cart-btn add-to-cart-btn ms-3" 
                                                            id="add-btn-{{ $product->id }}"
                                                            data-id="{{ $product->id }}"
                                                            data-item_no="{{ $product->item_no }}" 
                                                            data-product_name="{{ $product->product_name }}" 
                                                            data-price="{{ $product->price }}"
                                                            data-color="{{ $product->color ?? '' }}"
                                                            data-size="{{ $product->size ?? '' }}"
                                                            data-size2="{{ $product->size2 ?? '' }}"
                                                            data-size3="{{ $product->size3 ?? '' }}"
                                                            data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
                                                            data-img_small="{{ $product->img_small ?? '' }}"
                                                            data-img_large="{{ $product->img_large ?? '' }}"
                                                            data-display_size_2="{{ $product->display_size_2 ?? '' }}"
                                                            data-size2="{{ $product->size2 ?? '' }}"
                                                            data-size3="{{ $product->size3 ?? '' }}"
                                                            data-quantity="1"> Add to Cart
                                                    </button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="product-category-description">
                                    <strong>Includes:</strong><br>
                                    * Post * Tension Bars * Tension Bands * Rail Ends * Brace Bands * Cap
                                </div>
                            @else
                                <!-- Group other products by base name -->
                                @php
                                // Group products by base name (removing size info)
                                $productTypes = [];
                                
                                // For other categories, group by base name
                                foreach($group['products'] as $product) {
                                    // Extract base product name (without size)
                                    $baseName = preg_replace('/\s+\d+(\.\d+)?(\s*x\s*\d+(\.\d+)?)?(ft|in)?$/i', '', $product->product_name);
                                    $baseName = trim($baseName);
                                    
                                    if(!isset($productTypes[$baseName])) {
                                        $productTypes[$baseName] = [];
                                    }
                                    
                                    $productTypes[$baseName][] = $product;
                                }
                                @endphp
                                
                                @foreach($productTypes as $baseName => $products)
                                {{-- @dd($products) --}}
                                    <div class="product-item">
                                        <div class="product-item-header">
                                            <div class="product-item-title" style="margin-right: 8px">{{ $baseName }}</div>
                                            <div class="product-item-actions">
                                                @if(count($products) > 1)
                                                    <div class="size-select">
                                                        <label for="size-select-{{ $products[0]->id }}"></label>
                                                        <select class="form-select form-select-sm" id="size-select-{{ $products[0]->id }}" 
                                                                onchange="updateProductPrice(this, {{ json_encode(array_map(function($p) { 
                                                                    return ['id' => $p->id, 'price' => $p->price, 'item_no' => $p->item_no]; 
                                                                }, $products)) }})">
                                                            @foreach($products as $index => $product)
                                                                <option value="{{ $product->id }}" data-item="{{ $product->item_no }}" data-price="{{ $product->price }}">
                                                                    {{ $product->size ?? 'Standard' }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                
                                                <div class="product-controls">
                                                    <div class="quantity-control quantity-small">
                                                        <div class="quantity-btn quantity-minus" onclick="updateQuantity({{ $products[0]->id }}, -1)"><i class="bi bi-dash"></i></div>
                                                        <input type="number" id="quantity-{{ $products[0]->id }}" class="form-control quantity-input" value="1" min="1" onchange="updateTotalPrice({{ $products[0]->id }})">
                                                        <div class="quantity-btn quantity-plus" onclick="updateQuantity({{ $products[0]->id }}, 1)"><i class="bi bi-plus"></i></div>
                                                    </div>
                                                    <div class="total-price" id="total-price-{{ $products[0]->id }}">${{ number_format($products[0]->price, 2) }}</div>
                                                    <button class="btn btn-danger btn-sm cart-btn add-to-cart-btn ms-3" 
                                                            id="add-btn-{{ $products[0]->id }}"
                                                            data-id="{{ $products[0]->id }}"
                                                            data-item_no="{{ $products[0]->item_no }}" 
                                                            data-product_name="{{ $products[0]->product_name }}" 
                                                            data-price="{{ $products[0]->price }}"
                                                            data-color="{{ $products[0]->color ?? '' }}"
                                                            data-size="{{ $products[0]->size ?? '' }}"
                                                            data-size_in="{{ $products[0]->size_in ?? '' }}"
                                                            data-size_wt="{{ $products[0]->size_wt ?? '' }}"
                                                            data-size_ht="{{ $products[0]->size_ht ?? '' }}"
                                                            data-weight_lbs="{{ $products[0]->weight_lbs ?? '' }}"
                                                            data-img_small="{{ $products[0]->img_small ?? '' }}"
                                                            data-img_large="{{ $products[0]->img_large ?? '' }}"
                                                            data-display_size_2="{{ $products[0]->display_size_2 ?? '' }}"
                                                            data-size2="{{ $products[0]->size2 ?? '' }}"
                                                            data-size3="{{ $products[0]->size3 ?? '' }}"
                                                            data-material="{{ $products[0]->material ?? '' }}"
                                                            data-spacing="{{ $products[0]->spacing ?? '' }}"
                                                            data-coating="{{ $products[0]->coating ?? '' }}"
                                                            data-style="{{ $products[0]->style ?? '' }}"
                                                            data-speciality="{{ $products[0]->speciality ?? '' }}"
                                                            data-free_shipping="{{ $products[0]->free_shipping ?? '0' }}"
                                                            data-special_shipping="{{ $products[0]->special_shipping ?? '0' }}"
                                                            data-amount_per_box="{{ $products[0]->amount_per_box ?? '1' }}"
                                                            data-class="{{ $products[0]->class ?? '' }}"
                                                            data-categories_id="{{ $products[0]->categories_id ?? '' }}"
                                                            data-shipping_method="{{ $products[0]->shipping_method ?? '' }}"
                                                            data-quantity="1"> Add to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($categoryKey == 'fence_section')
                                    <div class="product-category-description">
                                        <strong>Includes:</strong><br>
                                        * Fabric * 1 3/8 Top Rail * 1 5/8 x 6ft Line Post * Loop Caps * Ties<br>
                                        {{-- <strong>** Add $1.00 per foot for runs under 50 feet **</strong><br>
                                        <strong>** For 1 3/8 Bottom Rail add $1.50 per foot **</strong><br>
                                        <strong>** For 1 5/8 Bottom Rail add $1.75 per foot **</strong> --}}
                                    </div>
                                @elseif($categoryKey == 'gates')
                                    <div class="product-category-description">
                                        <strong>Includes:</strong><br>
                                        * Complete assembled gate * All necessary hinges & hardware
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">
                        <p>No products found for {{ $height }} Chain Link Fence - {{ $systems[$system]['description'] }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, change) {
    const quantityInput = document.getElementById('quantity-' + productId);
    let quantity = parseInt(quantityInput.value) || 1;
    
    quantity += change;
    if (quantity < 1) quantity = 1;
    
    quantityInput.value = quantity;
    
    updateTotalPrice(productId);
}

function updateProductPrice(select, products) {
    const selectedOption = select.options[select.selectedIndex];
    const productId = select.value;
    const price = parseFloat(selectedOption.getAttribute('data-price'));
    const itemNo = selectedOption.getAttribute('data-item');
    
    // Update add button with new product info
    const addButton = document.getElementById('add-btn-' + products[0].id);
    addButton.setAttribute('data-item', itemNo);
    addButton.setAttribute('data-price', price);
    addButton.id = 'add-btn-' + productId;
    
    // Update total price
    const quantityInput = document.getElementById('quantity-' + products[0].id);
    const totalPriceElement = document.getElementById('total-price-' + products[0].id);
    
    if (quantityInput && totalPriceElement) {
        const quantity = parseInt(quantityInput.value) || 1;
        const totalPrice = price * quantity;
        
        totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
        
        // Update quantity input ID to match new product ID
        quantityInput.id = 'quantity-' + productId;
        totalPriceElement.id = 'total-price-' + productId;
    }
}

function updateTotalPrice(productId) {
    const sizeSelect = document.getElementById('size-select-' + productId);
    const quantityInput = document.getElementById('quantity-' + productId);
    const totalPriceElement = document.getElementById('total-price-' + productId);
    const addButton = document.getElementById('add-btn-' + productId);
    
    if (quantityInput && totalPriceElement && addButton) {
        let price = 0;
        
        // Get price from size select if it exists, otherwise use the total price element's current value
        if (sizeSelect) {
            const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
            price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        } else {
            // Get price from the total price element (remove $ and convert to number)
            const currentTotal = totalPriceElement.textContent;
            const currentPrice = parseFloat(currentTotal.replace('$', '')) || 0;
            // Since this is already the total, we need to divide by the previous quantity
            const prevQuantity = parseInt(addButton.getAttribute('data-quantity')) || 1;
            price = currentPrice / prevQuantity;
        }
        
        const quantity = parseInt(quantityInput.value) || 1;
        const totalPrice = price * quantity;
        
        totalPriceElement.textContent = '$' + totalPrice.toFixed(2);
        
        addButton.setAttribute('data-quantity', quantity);
        addButton.setAttribute('data-price', price);
    }
}

function toggleInstallation(event) {
    event.preventDefault();
    const installationContent = document.getElementById('installation-content');
    const toggleLink = document.getElementById('installation-toggle');
    const chevronIcon = toggleLink.querySelector('.bi-chevron-down');
    
    if (installationContent.classList.contains('collapse')) {
        installationContent.classList.remove('collapse');
        chevronIcon.classList.replace('bi-chevron-down', 'bi-chevron-up');
    } else {
        installationContent.classList.add('collapse');
        chevronIcon.classList.replace('bi-chevron-up', 'bi-chevron-down');
    }
}

// Initialize quantity buttons
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    const sizeSelects = document.querySelectorAll('[id^="size-select-"]');
    sizeSelects.forEach(select => {
        // Trigger change event to initialize prices
        const event = new Event('change');
        select.dispatchEvent(event);
    });
    
    // Initialize all quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        const productId = input.id.replace('quantity-', '');
        updateTotalPrice(productId);
    });
});
</script>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle quantity plus button clicks
        $('.quantity-plus').click(function() {
            var input = $(this).closest('.quantity-control').find('.quantity-input');
            var value = parseInt(input.val());
            input.val(value + 1);
        });
        
        // Handle quantity minus button clicks
        $('.quantity-minus').click(function() {
            var input = $(this).closest('.quantity-control').find('.quantity-input');
            var value = parseInt(input.val());
            if (value > 1) {
                input.val(value - 1);
            }
        });
        
        // Handle add to cart button clicks
        $('.add-to-cart-btn').click(function() {
            var button = $(this);
            var itemNo = button.data('item');
            var name = button.data('name');
            var price = button.data('price');
            var quantity = button.closest('.product-info').find('.quantity-input').val();
            
            // Add to cart AJAX call
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    item_no: itemNo,
                    product_name: name,
                    price: price,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert('Item added to cart!');
                        
                        // Update cart count in the header if it exists
                        if ($('.cart-count').length > 0) {
                            $('.cart-count').text(response.cartCount);
                        }
                    } else {
                        alert('Error adding item to cart');
                    }
                },
                error: function(xhr) {
                    alert('Error adding item to cart');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

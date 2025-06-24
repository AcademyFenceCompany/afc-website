@if(!$products->isEmpty())
<table class="table table-striped align-middle" id="productsTable">
    <thead>
        <tr>
            <th>Item Number</th>
            <th>Product Name</th>
            <th>Mesh</th>
            <th>Gauge</th>
            <th>In Stock</th>
            <th>Price</th>
            <th>Qty</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($products->take(20) as $product)
        <tr data-category="fence" data-price="120">
            <td>{{$product->item_no}} 
                @if(isset($product->color))
                    @php
                        $colorClass = match(strtolower($product->color)) {
                            'black' => 'bg-dark text-light',
                            'green' => 'bg-success text-light',
                            'brown' => 'bg-brown text-light', // You may need to define 'bg-brown' in your CSS
                            'white' => 'bg-white text-dark border',
                            'yellow' => 'bg-warning text-dark',
                            default => 'bg-secondary text-light',
                        };
                    @endphp
                    <span class="badge badge-pill {{ $colorClass }}">{{ ucfirst($product->color) }}</span>
                @endif
            </td>
            <td>{{ \Illuminate\Support\Str::limit($product->product_name, 40) }}</td>
            <td>{{$product->size2}}</td>
            <td>{{$product->size3}}</td>
            <td>
                @if($product->in_stock > 10)
                    <span class="badge rounded-pill bg-success">In Stock</span>
                @elseif($product->in_stock > 0)
                    <span class="badge rounded-pill bg-warning text-dark">Low ({{$product->in_stock}})</span>
                @else
                    <span class="badge rounded-pill bg-danger">Out of Stock</span>
                @endif
            </td>
            <td>${{$product->price}}</td>
            <td>
                <input type="number" class="form-control form-control-sm incre-qty" data-product-id="{{$product->id}}" value="1" min="0" max="100">
            </td>
            <td>
                <button class="btn btn-success text-light btn-sm add-to-cart" data-product-id="{{$product->id}}" title="Add to Cart">
                    <i class="bi bi-cart-plus"></i>
                </button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@else
<div class="alert alert-danger" role="alert">
    No products available in this category.
</div>
@endif
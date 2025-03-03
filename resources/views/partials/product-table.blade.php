<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Item No</th>
                <th>Height</th>
                <th>Color</th>
                <th>Mesh Size</th>
                <th>Weight</th>
                <th>Price</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @php
                    $firstVariant = $product->color_variants->first();
                    $productName = $product->product_name;
                @endphp
                <tr data-product-row="{{ $product->product_id }}">
                    <td class="item-no">{{ $firstVariant['item_no'] }}</td>
                    <td>{{ $product->size1 }}'</td>
                    <td>
                        @php
                            $variantsJson = json_encode($product->color_variants);
                        @endphp
                        <select class="form-select color-select" data-variants='{{ $variantsJson }}'
                            onchange="updateProductDetails(this)">
                            @foreach ($product->available_colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="mesh-size">{{ $firstVariant['size2'] }}</td>
                    <td class="weight">{{ $firstVariant['weight'] ?? '-' }} lbs</td>
                    <td class="price">${{ number_format($product->price_per_unit, 2) }}</td>
                    <td>
                        <div class="input-group" style="width: 120px;">
                            <button class="btn btn-outline-secondary quantity-decrease" type="button">-</button>
                            <input type="text" class="form-control text-center quantity-input" value="1"
                                data-price="{{ $product->price_per_unit }}">
                            <button class="btn btn-outline-secondary quantity-increase" type="button">+</button>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger add-to-cart-btn" data-item="{{ $firstVariant['item_no'] }}"
                            data-price="{{ $product->price_per_unit }}" data-product-name="{{ $productName }}"
                            data-size1="{{ $product->size1 }}" data-size2="{{ $firstVariant['size2'] }}"
                            data-weight="{{ $firstVariant['weight'] }}"
                            data-family-category="{{ $product->family_category_id }}"
                            data-shipping-length="{{ $product->shipping_length }}"
                            data-shipping-width="{{ $product->shipping_width }}"
                            data-shipping-height="{{ $product->shipping_height }}"
                            data-shipping-class="{{ $product->shipping_class }}">
                            Add to Cart
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

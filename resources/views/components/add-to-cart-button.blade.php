@if($product)
<button class="btn btn-sm btn-danger text-white ms-2 add-to-cart-btn"
    data-id="{{ $product->id }}"
    data-item_no="{{ $product->item_no }}" 
    data-product_name="{{ $product->product_name }}"
    data-price="{{ $product->price }}"
    data-color="{{ $product->color ?? '' }}"
    data-size="{{ $product->size ?? '' }}"
    data-size_in="{{ $product->size_in ?? '' }}"
    data-size_wt="{{ $product->size_wt ?? '' }}"
    data-size_ht="{{ $product->size_ht ?? '' }}"
    data-weight_lbs="{{ $product->weight_lbs ?? '' }}"
    data-img_small="{{ $product->img_small ?? '' }}"
    data-img_large="{{ $product->img_large ?? '' }}"
    data-display_size_2="{{ $product->display_size_2 ?? '' }}"
    data-size2="{{ $product->size2 ?? '' }}"
    data-size3="{{ $product->size3 ?? '' }}"
    data-material="{{ $product->material ?? '' }}"
    data-spacing="{{ $product->spacing ?? '' }}"
    data-coating="{{ $product->coating ?? '' }}"
    data-style="{{ $product->style ?? '' }}"
    data-speciality="{{ $product->speciality ?? '' }}"
    data-free_shipping="{{ $product->free_shipping ?? '0' }}"
    data-special_shipping="{{ $product->special_shipping ?? '0' }}"
    data-amount_per_box="{{ $product->amount_per_box ?? '1' }}"
    data-class="{{ $product->class ?? '' }}"
    data-categories_id="{{ $product->categories_id ?? '' }}"
    data-ship_length="{{ $product->ship_length ?? '' }}"
    data-ship_width="{{ $product->ship_width ?? '' }}"
    data-ship_height="{{ $product->ship_height ?? '' }}"
    data-shipping_method="{{ $product->shipping_method ?? '' }}">
    Add to Cart
</button>
@else
<button class="btn btn-sm btn-danger text-white ms-2 disabled">
    Add to Cart
</button>
@endif

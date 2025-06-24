<div class="">
    <div  class="row">
        <div class="col-md-12">
        @foreach ($groupedProducts as $groupLabel => $items)
            <p class="bg-secondary text-light p-2 m-0 text-center" style="font-size: 0.85em;">
                Mesh Size: {{ $groupLabel }}
            </p>
            <table class="table m-0" style="font-size: 0.85em;">
                <thead>
                <tr>
                    <th>Item Number</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>In Stock</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->item_no ?? '' }}</td>
                    <td>{{ $item->size ?? '' }}</td>
                    <td>{{ $item->price ?? '' }}</td>
                    <td>{{ $item->in_stock ?? '' }}</td>
                    <td>
                        <input type="number" class="form-control form-control-sm incre-qty" data-product-id="{{ $item->id }}" name="quantity_{{ $item->item_no ?? '' }}" min="1" value="1" style="width:60px;">
                    </td>
                    <td>
                        <button type="button" class="btn btn-success text-light btn-sm add-to-cart" data-product-id="{{ $item->id }}">
                            <i class="bi bi-cart-plus"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
        </div>
    </div>
</div>

@forelse($products as $product)
    <tr>
        <td>{{ $product->item_no }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->familyCategory->family_category_name ?? 'N/A' }}</td>
        <td>${{ number_format($product->price_per_unit, 2) }}</td>
        <td>{{ $product->inventory->in_stock_hq ?? 0 }}</td>
        <td>{{ $product->inventory->in_stock_warehouse ?? 0 }}</td>
        <td>
            @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-primary">Edit</a>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4">No products found</td>
    </tr>
@endforelse

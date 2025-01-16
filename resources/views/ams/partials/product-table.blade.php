@forelse($products as $product)
    <tr>
        <td>{{ $product->item_no ?? '' }}</td>
        <td>{{ $product->product_name ?? '' }}</td>
        <td>{{ $product->family_category->family_category_name ?? 'N/A' }}</td>
        <td>${{ number_format($product->price_per_unit ?? 0, 2) }}</td>
        <td>{{ $product->inventory->in_stock_hq ?? 0 }}</td>
        <td>{{ $product->inventory->in_stock_warehouse ?? 0 }}</td>
        <td>
            <div class="d-flex gap-2">
                @if ($product->color)
                    <small class="badge bg-light text-dark">Color: {{ $product->color }}</small>
                @endif
                @if ($product->style)
                    <small class="badge bg-light text-dark">Style: {{ $product->style }}</small>
                @endif
                @if ($product->specialty)
                    <small class="badge bg-light text-dark">Specialty: {{ $product->specialty }}</small>
                @endif
                @if ($product->size1)
                    <small class="badge bg-light text-dark">Size 1: {{ $product->size1 }}</small>
                @endif
                @if ($product->size2)
                    <small class="badge bg-light text-dark">Size 2: {{ $product->size2 }}</small>
                @endif
                @if ($product->size3)
                    <small class="badge bg-light text-dark">Size 3: {{ $product->size3 }}</small>
                @endif
            </div>
            @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-sm btn-primary mt-1">Edit</a>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4">No products found</td>
    </tr>
@endforelse

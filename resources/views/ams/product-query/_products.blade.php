<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Products in Category</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Item No</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Enabled</th>
                    <th>Stock (Orange)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->item_no }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->enabled ? 'Yes' : 'No' }}</td>
                    <td>{{ $product->inv_orange }}</td>
                    <td>
                        <a href="{{ route('ams.product-query.edit', $product->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="m-3 pagination-container">
            {{ $products->links() }}
        </div>
    </div>
</div>


    

    <!-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif -->

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="family_category_id" class="form-label">Category ID</label>
            <input type="number" class="form-control" name="family_category_id" required>
        </div>

        <div class="mb-3">
            <label for="family_category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="family_category_name" required>
        </div>

        <div class="mb-3">
            <label for="parent_category_id" class="form-label">Parent Category ID (Optional)</label>
            <input type="number" class="form-control" name="parent_category_id">
        </div>

        <div class="mb-3">
            <label for="category_description" class="form-label">Category Description</label>
            <textarea class="form-control" name="category_description"></textarea>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="product_name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" required>
        </div>

        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" name="stock_quantity" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection
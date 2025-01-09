{{-- <pre>{{ dd($products) }}</pre> --}}
@extends('layouts.ams')

@section('title', 'Products')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Products</h3>
                @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
                @endif
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                            results
                        @else
                            No results found
                        @endif
                    </div>
                    <div>
                        <select class="form-select" onchange="window.location.href = this.value">
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 10]) }}"
                                {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 25]) }}"
                                {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}"
                                {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}"
                                {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item No</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock (HQ)</th>
                                <th>Stock (WH)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <!-- Add this debug line temporarily -->
                                    @php
                                        \Log::info('Product data:', [
                                            'product_id' => $product->product_id,
                                            'has_inventory' => $product->inventory ? 'yes' : 'no',
                                            'has_category' => $product->familyCategory ? 'yes' : 'no',
                                            'raw_product' => $product->toArray(),
                                        ]);
                                    @endphp
                                    <td>{{ $product->item_no }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->familyCategory->family_category_name ?? 'N/A' }}</td>
                                    <td>${{ number_format($product->price_per_unit, 2) }}</td>
                                    <td>{{ $product->inventory->in_stock_hq ?? 0 }}</td>
                                    <td>{{ $product->inventory->in_stock_warehouse ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->product_id) }}"
                                            class="btn btn-sm btn-info">
                                            View
                                        </a>
                                        @if (auth()->user()->level === 'God' || auth()->user()->level === 'Admin')
                                            <a href="{{ route('products.edit', $product->product_id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product->product_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No products found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        @if ($products->total() > 0)
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                            {{ $products->total() }} results
                        @endif
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

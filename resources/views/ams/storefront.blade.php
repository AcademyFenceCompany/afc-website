@extends('layouts.ams')
@section('title', 'AMS Storefront')
@section('content')
<div class="container-fluid p-4">
    <h1>AMS Storefront</h1>
    <p>Welcome to the AMS Storefront page.</p>
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4>Filter Products</h4>
                </div>
                <div class="card-body">
                    <p>Use the filters below to narrow down your product search.</p>
                    <form id="filterForm">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="" disabled selected>--Choose an option--</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hw_roll" class="form-label">{{$columnHeaders['size']}}</label>
                            <select class="form-select" id="hw_roll" name="size">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['size']['size'] as $size)
                                    <option value="{{ $size }}">{{ ucfirst($size) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="size2" class="form-label">{{$columnHeaders['size2'] ?? 'Size 2'}}</label>
                            <select class="form-select" id="size2" name="size2">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['size2']['size2'] ?? [] as $size2)
                                    <option value="{{ $size2 }}">{{ ucfirst($size2) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="size3" class="form-label">{{$columnHeaders['size3'] ?? 'Size 3'}}</label>
                            <select class="form-select" id="size3" name="size3">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['size3']['size3'] ?? [] as $size3)
                                    <option value="{{ $size3 }}">{{ ucfirst($size3) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">{{$columnHeaders['color'] ?? 'Color'}}</label>
                            <select class="form-select" id="color" name="color">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['color']['color'] ?? [] as $color)
                                    <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="style" class="form-label">{{$columnHeaders['style'] ?? 'Style'}}</label>
                            <select class="form-select" id="style" name="style">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['style']['style'] ?? [] as $style)
                                    <option value="{{ $style }}">{{ ucfirst($style) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="spacing" class="form-label">{{$columnHeaders['spacing'] ?? 'Spacing'}}</label>
                            <select class="form-select" id="spacing" name="spacing">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['spacing']['spacing'] ?? [] as $spacing)
                                    <option value="{{ $spacing }}">{{ ucfirst($spacing) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="speciality" class="form-label">{{$columnHeaders['speciality'] ?? 'Speciality'}}</label>
                            <select class="form-select" id="speciality" name="speciality">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['speciality']['speciality'] ?? [] as $speciality)
                                    <option value="{{ $speciality }}">{{ ucfirst($speciality) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="coating" class="form-label">{{$columnHeaders['coating'] ?? 'Coating'}}</label>
                            <select class="form-select" id="coating" name="coating">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['coating']['coating'] ?? [] as $coating)
                                    <option value="{{ $coating }}">{{ ucfirst($coating) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="material" class="form-label">{{$columnHeaders['material'] ?? 'Material'}}</label>
                            <select class="form-select" id="material" name="material">
                                <option value="" disabled selected>--Choose an option--</option>
                                @foreach($filters['material']['material'] ?? [] as $material)
                                    <option value="{{ $material }}">{{ ucfirst($material) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                    </form>
                </div>
                <div class="card-footer">
                    <p>Note: Filters are applied dynamically. Use the buttons below to reset or clear filters.</p>
                    <button class="btn btn-secondary btn-sm" onclick="document.getElementById('filterForm').reset();">Reset Filters</button>
                </div>
            </div>
        </div>
        <!-- Product Table -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4>Available Products</h4>
                </div>
                <div class="card-body">
                    <p>Browse our selection of products below. Use the filters to find what you need.</p>
                    <table class="table table-striped align-middle" id="productsTable">
                        <thead>
                            <tr>
                                <th>Item Number</th>
                                <th>Product Name</th>
                                <th>Size</th>
                                <th>In Stock</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example products -->
                            <tr data-category="fence" data-price="120">
                                <td>1001</td>
                                <td>Classic Wood Fence Panel</td>
                                <td>6ft x 8ft</td>
                                <td>
                                    <span class="badge rounded-pill bg-success">Yes</span>
                                </td>
                                <td>$120</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="1" min="1" max="10">
                                </td>
                                <td>
                                    <button class="btn btn-success text-light btn-sm" title="Add to Cart">
                                        <i class="bi pe-2 bi-cart-plus"></i> Add to Cart
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="gate" data-price="180">
                                <td>1002</td>
                                <td>Steel Driveway Gate</td>
                                <td>12ft x 4ft</td>
                                <td>
                                    <span class="badge rounded-pill bg-success">Yes</span>
                                </td>
                                <td>$180</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="1" min="1" max="5">
                                </td>
                                <td>
                                    <button class="btn btn-success text-light btn-sm" title="Add to Cart">
                                        <i class="bi pe-2 bi-cart-plus"></i> Add to Cart
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="hardware" data-price="15">
                                <td>1003</td>
                                <td>Gate Hinge Set</td>
                                <td>Standard</td>
                                <td>
                                    <span class="badge rounded-pill bg-warning text-dark">Low</span>
                                </td>
                                <td>$15</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="1" min="1" max="20">
                                </td>
                                <td>
                                    <button class="btn btn-success text-light btn-sm" title="Add to Cart">
                                        <i class="bi pe-2 bi-cart-plus"></i> Add to Cart
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="fence" data-price="95">
                                <td>1004</td>
                                <td>Vinyl Privacy Fence Panel</td>
                                <td>6ft x 6ft</td>
                                <td>
                                    <span class="badge rounded-pill bg-danger">No</span>
                                </td>
                                <td>$95</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="1" min="1" max="10" disabled>
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm" title="Out of Stock" disabled>
                                        <i class="bi pe-2 bi-cart-x"></i> Out of Stock
                                    </button>
                                </td>
                            </tr>
                            <tr data-category="accessory" data-price="8">
                                <td>1005</td>
                                <td>Post Cap - Black</td>
                                <td>4x4</td>
                                <td>
                                    <span class="badge rounded-pill bg-success">Yes</span>
                                </td>
                                <td>$8</td>
                                <td>
                                    <input type="number" class="form-control form-control-sm" value="1" min="1" max="50">
                                </td>
                                <td>
                                    <button class="btn btn-success text-light btn-sm" title="Add to Cart">
                                        <i class="bi pe-2 bi-cart-plus"></i> Add to Cart
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <p>Total Products: <span id="totalProducts">4</span></p>
                    <p>Use the filters to narrow down your search.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const category = document.getElementById('category').value;
        const priceRange = document.getElementById('priceRange').value;
        const rows = document.querySelectorAll('#productsTable tbody tr');
        rows.forEach(row => {
            let show = true;
            if (category && row.dataset.category !== category) show = false;
            if (priceRange) {
                const [min, max] = priceRange.split('-').map(Number);
                const price = Number(row.dataset.price);
                if (price < min || price > max) show = false;
            }
            row.style.display = show ? '' : 'none';
        });
    });
    </script>
</div>
@endsection

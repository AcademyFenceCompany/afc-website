@extends('layouts.ams')

@section('title', 'Add Product')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Add Product</h2>

        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required>
                    </div>

                    <!-- Item Number -->
                    <div class="mb-3">
                        <label for="item_number" class="form-label">Item Number</label>
                        <input type="text" name="item_number" id="item_number" class="form-control" required>
                    </div>

                    <!-- Master Model -->
                    <div class="mb-3">
                        <label for="master_model" class="form-label">Master Model</label>
                        <select name="master_model" id="master_model" class="form-select">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </div>

                    <!-- Master Code -->
                    <div class="mb-3">
                        <label for="master_code" class="form-label">Master Code</label>
                        <input type="text" name="master_code" id="master_code" class="form-control">
                    </div>

                    <!-- Class -->
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" name="class" id="class" class="form-control">
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="2"></textarea>
                    </div>

                    <!-- Long Description -->
                    <div class="mb-3">
                        <label for="long_description" class="form-label">Long Description</label>
                        <textarea name="long_description" id="long_description" class="form-control" rows="4"></textarea>
                    </div>

                    <!-- Color -->
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" name="color" id="color" class="form-control">
                    </div>

                    <!-- Alternate Size -->
                    <div class="mb-3">
                        <label for="alternate_size" class="form-label">Alternate Size</label>
                        <div class="d-flex">
                            <input type="text" name="alternate_length" placeholder="Length" class="form-control me-2">
                            <input type="text" name="alternate_width" placeholder="Width" class="form-control me-2">
                            <input type="text" name="alternate_height" placeholder="Height" class="form-control">
                        </div>
                    </div>
                    <!-- Nominal Size -->
                    <div class="mb-3">
                        <label for="alternate_size" class="form-label">Nominal Size</label>
                        <div class="d-flex">
                            <input type="text" name="alternate_length" placeholder="Length" class="form-control me-2">
                            <input type="text" name="alternate_width" placeholder="Width" class="form-control me-2">
                            <input type="text" name="alternate_height" placeholder="Height" class="form-control">
                        </div>
                    </div>
                    <!--  Shipping Box Size-->
                    <div class="mb-3">
                        <label for="alternate_size" class="form-label">Shipping Box Size</label>
                        <div class="d-flex">
                            <input type="text" name="alternate_length" placeholder="Length"
                                class="form-control me-2">
                            <input type="text" name="alternate_width" placeholder="Width" class="form-control me-2">
                            <input type="text" name="alternate_height" placeholder="Height" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Product List Price -->
                    <div class="mb-3">
                        <label for="product_list_price" class="form-label">Product List Price</label>
                        <input type="number" name="product_list_price" id="product_list_price" class="form-control"
                            step="0.01">
                    </div>

                    <!-- Product Cost -->
                    <div class="mb-3">
                        <label for="product_cost" class="form-label">Product Cost</label>
                        <input type="number" name="product_cost" id="product_cost" class="form-control"
                            step="0.01">
                    </div>

                    <!-- Product Sell Price -->
                    <div class="mb-3">
                        <label for="product_sell_price" class="form-label">Product Sell Price</label>
                        <input type="number" name="product_sell_price" id="product_sell_price" class="form-control"
                            step="0.01">
                    </div>

                    <!-- Product Wholesale Price -->
                    <div class="mb-3">
                        <label for="product_wholesale_price" class="form-label">Product Wholesale Price</label>
                        <input type="number" name="product_wholesale_price" id="product_wholesale_price"
                            class="form-control" step="0.01">
                    </div>

                    <!-- Weight -->
                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight</label>
                        <input type="number" name="weight" id="weight" class="form-control" step="0.01">
                    </div>

                    <!-- Inventory Total -->
                    <div class="mb-3">
                        <label for="inventory_total" class="form-label">Inventory Total</label>
                        <input type="number" name="inventory_total" id="inventory_total" class="form-control">
                    </div>

                    <!-- Meta Title -->
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control">
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Large Image -->
                    <div class="mb-3">
                        <label for="large_image" class="form-label">Large Image</label>
                        <input type="file" name="large_image" id="large_image" class="form-control">
                    </div>

                    <!-- Small Image -->
                    <div class="mb-3">
                        <label for="small_image" class="form-label">Small Image</label>
                        <input type="file" name="small_image" id="small_image" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
@endsection

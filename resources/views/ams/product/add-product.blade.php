@extends('layouts.ams')

@section('title', 'Add Product')

@section('content')
<div class="container">
    <h2 class="add_product__title ">Add Product</h2>
    <!-- text-center mb-4  -->

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Product Information -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">Product Information</div>
                    <div class="card-body">

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" name="product[product_name]" id="product_name" class="form-control"
                                    placeholder="Type product name..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Item Number</label>
                                <input type="text" name="product[item_no]" id="item_no" class="form-control"
                                    placeholder="Type item number.." required>
                            </div>
                        </div>

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Color</label>
                                <input type="text" name="details[color]" id="product_name" class="form-control"
                                    placeholder="Type color..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Material</label>
                                <input type="text" name="details[material]" id="item_no" class="form-control"
                                    placeholder="Type material.." required>
                            </div>
                        </div>

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Style</label>
                                <input type="text" name="details[style]" id="product_name" class="form-control"
                                    placeholder="Type style..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="family_category_id" class="form-label">Category</label>
                                <select name="product[family_category_id]" id="family_category_id" class="form-control"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach ($familyCategories as $category)
                                        <option value="{{ $category->family_category_id }}">
                                            {{ $category->family_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="card__input">
                            <label class="form-label">Sizes</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="details[size1]" placeholder="Size 1" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="details[size2]" placeholder="Size 2" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="details[size3]" placeholder="Size 3" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="card mb-4">
                    <div class="card-header">Pricing & Inventory</div>
                    <div class="card-body">

                        <div class="card__input">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Inventory Total</label>
                                    <input type="text" name="details[size1]" placeholder="Type inv number..."
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Inventory Day St</label>
                                    <input type="text" name="details[size2]" placeholder="Type inv number..."
                                        class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Inv East Orange</label>
                                    <input type="text" name="details[size3]" placeholder="Type inv number..."
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Product Cost</label>
                                <input type="text" name="product[product_name]" id="product_name" class="form-control"
                                    placeholder="Type price..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Product List</label>
                                <input type="text" name="product[item_no]" id="item_no" class="form-control"
                                    placeholder="Type price..." required>
                            </div>
                        </div>

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Product Sell Price</label>
                                <input type="text" name="details[color]" id="product_name" class="form-control"
                                    placeholder="Type price..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Product Wholesale Price</label>
                                <input type="text" name="details[price]" id="item_no" class="form-control"
                                    placeholder="Type price..." required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card mb-6">
                    <div class="card-header">Shipping Details</div>
                    <div class="card-body">


                        <div class="card__input">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label">Shippable?</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable]" value="1" class="form-check-input"
                                            id="shippable_yes" required>
                                        <label class="form-check-label" for="shippable_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable]" value="0" class="form-check-input"
                                            id="shippable_no" required>
                                        <label class="form-check-label" for="shippable_no">No</label>

                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Shippable?</label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable]" value="1" class="form-check-input"
                                            id="shippable_yes" required>
                                        <label class="form-check-label" for="shippable_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable]" value="0" class="form-check-input"
                                            id="shippable_no" required>
                                        <label class="form-check-label" for="shippable_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="shipping_class" class="form-label">Shipping Class</label>
                            <input type="text" name="shipping[shipping_class]" id="shipping_class" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shipping Dimensions</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" name="shipping[shipping_length]" placeholder="Length"
                                        class="form-control" step="0.01">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="shipping[shipping_width]" placeholder="Width"
                                        class="form-control" step="0.01">
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="shipping[shipping_height]" placeholder="Height"
                                        class="form-control" step="0.01">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <input type="number" name="shipping[weight]" id="weight" class="form-control" step="0.01">
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="shipping[free_shipping]" id="free_shipping"
                                    class="form-check-input">
                                <label class="form-check-label" for="free_shipping">Free Shipping</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <!-- Pricing Information -->
                <div class="card mb-4">
                    <div class="card-header">Pricing</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost*</label>
                            <input type="number" name="product[cost]" id="cost" class="form-control" step="0.01"
                                required>
                        </div>

                        <div class="card__input">
                            <label for="price_per_unit" class="form-label">Price Per Unit*</label>
                            <input type="number" name="product[price_per_unit]" id="price_per_unit" class="form-control"
                                step="0.01" required>
                        </div>
                    </div>
                </div>

                <!-- Media -->
                <div class="card mb-4">
                    <div class="card-header">Product Images</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="large_image" class="form-label">Large Image</label>
                            <input type="file" name="media[large_image]" id="large_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="small_image" class="form-label">Small Image</label>
                            <input type="file" name="media[small_image]" id="small_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="general_image" class="form-label">General Image</label>
                            <input type="file" name="media[general_image]" id="general_image" class="form-control">
                        </div>

                        <div class="card__input">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="product[description]" id="description" class="form-control"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="card mb-4">
                    <div class="card-header">Inventory</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="in_stock_hq" class="form-label">In Stock (HQ)</label>
                            <input type="number" name="inventory[in_stock_hq]" id="in_stock_hq" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="in_stock_warehouse" class="form-label">In Stock (Warehouse)</label>
                            <input type="number" name="inventory[in_stock_warehouse]" id="in_stock_warehouse"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="inventory_ordered" class="form-label">Ordered Inventory</label>
                            <input type="number" name="inventory[inventory_ordered]" id="inventory_ordered"
                                class="form-control" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 mb-5">
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
@endsection
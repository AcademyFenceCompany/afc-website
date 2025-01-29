@extends('layouts.ams')

@section('title', 'Add Product')

@section('content')

<div class="container">

    <div class="row add_product__title">
        <h2>ADD PRODUCT</h2>
    </div>

    <!-- text-center mb-4  -->
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Product Information -->
            <div class="col-md-6">
                <div class="card card__input">
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
                                <input type="text" name="details[material]" id="material" class="form-control"
                                    placeholder="Type material.." required>
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Style</label>
                                <input type="text" name="details[style]" id="style" class="form-control"
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
                <div class="card card__input">
                    <div class="card-header">Pricing & Inventory</div>
                    <div class="card-body">

                        <div class="row card__input">
                            <div class="col-md-4">
                                <label class="form-label">Inventory Total</label>
                                <input type="text" name="inventory[inv_total]" placeholder="Type inv number..."
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Inventory Day St</label>
                                <input type="text" name="inventory[inv_day_st]" placeholder="Type inv number..."
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Inv East Orange</label>
                                <input type="text" name="inventory[inv_east_org]" placeholder="Type inv number..."
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Product Cost</label>
                                <input type="text" name="details[product_cost]" id="cost" class="form-control"
                                    step="0.01" placeholder="Type product cost..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Product List</label>
                                <input type="text" name="product[list_price]" id="item_no" class="form-control"
                                    placeholder="Type list price..." required>
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Product Sell Price</label>
                                <input type="text" name="details[sell_price]" id="product_name" class="form-control"
                                    placeholder="Type sell price..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="item_no" class="form-label">Product Wholesale Price</label>
                                <input type="text" name="details[wholesale_price]" id="item_no" class="form-control"
                                    placeholder="Type wholesale price..." required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card card__input">
                    <div class="card-header">Shipping Details</div>
                    <div class="card-body">

                        <div class="row card__input">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label class="form-label">Shippable?</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable_yes]" value="1"
                                            class="form-check-input" id="shippable_yes" required>
                                        <label class="form-check-label" for="shippable_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="radio" name="product[shippable_no]" value="0"
                                            class="form-check-input" id="shippable_no" required>
                                        <label class="form-check-label" for="shippable_no">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label class="form-label">Special Shipping?</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="radio" name="product[sp_shippable]" value="1"
                                            class="form-check-input" id="sp_shippable_yes" required>
                                        <label class="form-check-label" for="sp_shippable_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="radio" name="product[sp_shippable_no]" value="0"
                                            class="form-check-input" id="sp_shippable_no" required>
                                        <label class="form-check-label" for="sp_shippable_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <label for="shipping_class" class="form-label">Shipping Class</label>
                                <select name="product[shipping_class]" id="shipping_class" class="form-control"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach ($familyCategories as $category)
                                        <option value="{{ $category->family_category_id }}">
                                            {{ $category->family_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Amount Per Box</label>
                                <input type="text" name="product[amount_per_box]" id="amount_per_box"
                                    class="form-control" placeholder="Type amount per box..." required>
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="shipping[containar_shipping]" id="containar_shipping"
                                        class="form-check-input">
                                    <label class="form-check-label" for="containar_shipping">Containar</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="shipping[truckload_shipping]" id="truckload_shipping"
                                        class="form-check-input">
                                    <label class="form-check-label" for="truckload_shipping">Truckload</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="shipping[pallet_shipping]" id="pallet_shipping"
                                        class="form-check-input">
                                    <label class="form-check-label" for="pallet_shipping">Pallet</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="shipping[case_shipping]" id="case_shipping"
                                        class="form-check-input">
                                    <label class="form-check-label" for="case_shipping">Case</label>
                                </div>
                            </div>
                        </div>

                        <div class="row card__input">
                            <label class="form-label">Alternate Size</label>
                            <div class="col-md-4">
                                <input type="number" name="shipping[alt_shipping_length]" placeholder="Length"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[alt_shipping_width]" placeholder="Width"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[alt_shipping_height]" placeholder="Height"
                                    class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="row card__input">
                            <label class="form-label">Nominal Size</label>

                            <div class="col-md-4">
                                <input type="number" name="shipping[n_shipping_length]" placeholder="Length"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[n_shipping_width]" placeholder="Width"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[n_shipping_height]" placeholder="Height"
                                    class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="row card__input">
                            <label class="form-label">Shipping Box Size</label>
                            <div class="col-md-4">
                                <input type="number" name="shipping[box_shipping_length]" placeholder="Length"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[box_shipping_width]" placeholder="Width"
                                    class="form-control" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="shipping[box_shipping_height]" placeholder="Height"
                                    class="form-control" step="0.01">
                            </div>
                        </div>

                        <div class="row card__input">
                            <div class="col-md-6">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="number" name="shipping[weight]" id="weight" class="form-control"
                                    step="0.01" placeholder="Type product weight...">
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="shipping[free_shipping]" id="free_shipping"
                                class="form-check-input">
                            <label class="form-check-label" for="free_shipping">Free Shipping</label>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <!-- Display Detalis -->
                <div class="card mb-4">
                    <div class="card-header">Display Details</div>
                    <div class="card-body">

                        <div class="row card__input">
                            <div class="col-md-12">
                                <label class="form-label">Enabled</label>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="radio" name="product[enable_yes]" value="1" class="form-check-input"
                                        id="enable_yes" required>
                                    <label class="form-check-label" for="enable_yes">Yes</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="radio" name="product[disable_no]" value="0" class="form-check-input"
                                        id="disable_no" required>
                                    <label class="form-check-label" for="disable_no">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="card__input row">
                            <div class="col-md-6">
                                <label for="associated_products" class="form-label">Associated Products</label>
                                <input type="text" name="product[associated_products]" id="associated_products"
                                    class="form-control" placeholder="Type associated products..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="related_products" class="form-label">Related Products</label>
                                <input type="text" name="product[related_products]" id="related_products"
                                    class="form-control" placeholder="Type related products..." required>
                            </div>
                        </div>

                        <div class="card__input">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="product[meta_title]" id="meta_title" class="form-control"
                                placeholder="Type meta title..." required>
                        </div>

                        <div class="card__input">
                            <label for="meta_descr" class="form-label">Meta Description</label>
                            <input type="text" name="product[meta_descr]" id="meta_descr" class="form-control"
                                placeholder="Type meta description..." required>
                        </div>

                        <div class="card__input">
                            <label for="meta_keyws" class="form-label">Meta keywords</label>
                            <input type="text" name="product[meta_keyws]" id="meta_keyws" class="form-control"
                                placeholder="Type meta keywords..." required>
                        </div>

                        <div class="card__input">
                            <label for="s_description" class="form-label">Small Description</label>
                            <textarea name="product[s_description]" id="s_description" class="form-control" rows="3"
                                placeholder="Type small description..."></textarea>
                        </div>

                        <div class="card__input">
                            <label for="l_description" class="form-label">Long Description</label>
                            <textarea name="product[l_description]" id="l_description" class="form-control" rows="3"
                                placeholder="Type long description..."></textarea>
                        </div>

                        <div class="card__input">
                            <label for="large_image" class="form-label">Large Image</label>
                            <input type="file" name="media[large_image]" id="large_image" class="form-control">
                        </div>

                        <div class="card__input">
                            <label for="small_image" class="form-label">Small Image</label>
                            <input type="file" name="media[small_image]" id="small_image" class="form-control">
                        </div>

                        <div class="card__input">
                            <label for="general_image" class="form-label">General Image</label>
                            <input type="file" name="media[general_image]" id="general_image" class="form-control">
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
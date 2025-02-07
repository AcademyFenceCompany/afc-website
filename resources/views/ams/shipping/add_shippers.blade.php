@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">

    <div class="row add_product__title">
        <h2>ADD SHIPPERS</h2>
    </div>


    <div class="row">
        <!-- Product Information -->
        <div class="col-md-6">
            <div class="card card__input">
                <div class="card-header">Information About Shipper</div>
                <div class="card-body">

                    <div class="card__input row">
                        <div class="col-md-6">
                            <label for="product_name" class="form-label">Shipper Name</label>
                            <input type="text" name="product[product_name]" id="product_name" class="form-control"
                                placeholder="Type shipper name..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="item_no" class="form-label">Shipper's Website</label>
                            <input type="text" name="product[item_no]" id="item_no" class="form-control"
                                placeholder="Type shipper's website.." required>
                        </div>
                    </div>

                    <div class="card__input row">
                        <div class="col-md-6">
                            <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse"
                                data-bs-target=""></i>
                            <label for="shipper_type" class="form-label">Shipper Type</label>
                            <select name="" id="shipper_type" class="form-control" required>
                                <option value="">Select Type</option>
                            </select>
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

        </div>

        @endsection
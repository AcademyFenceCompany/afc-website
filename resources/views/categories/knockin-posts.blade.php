@extends('layout')

@section('content')

@include('partials.webheader')

<div class="container-fluid py-4 mb-5">
    <div class="container">

        <h2 class="section-title text-center mb-4">Knock-in Posts</h2>
        <p class="welded-wire-desc">Our premium knock-in posts provide sturdy support for your fencing needs. Made from durable materials, these posts are designed for easy installation and long-lasting performance.</p>
        <div class="content-wrapper mt-5 pb-1 margin10rem" style="background-color: white; border-radius: 5px; box-shadow: 0 2px 15px 0 rgba(0,0,0,0.1); padding: 20px;">
        <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
        }

        .table thead th {
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }

        .item-number {
            color: #dc3545;
            font-weight: 500;
            text-decoration: none;
        }

        .item-number:hover {
            text-decoration: underline;
        }

        .mesh__title {
            color: white;
        }

        .card-header {
            text-align: center;
        }

        .product_img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
            display: block;
            margin: 0 auto;
        }

        .input-group {
            margin-bottom: 0;
        }

        .btn-add-to-cart {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
        }

        .btn-add-to-cart:hover {
            background-color: #c82333;
        }

        @media (max-width: 767px) {
            .mobile-table-wrapper {
                overflow-x: auto;
            }
        }
        /* Add some spacing to the quantity section */
        .quantity-section {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        </style>
            
        <!-- Knock-in Posts Section -->
        <div class="mt-0">
            <div class="bg-danger text-white text-center py-2 rounded">
                <h4 class="m-0 mesh__title">Knock-in Posts</h4>
            </div>
            <div class="row mt-1">
                <!-- Left Image -->
                <div class="col-md-2 text-center mb-4 mb-md-0">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white fw-bold py-1 rounded">
                            <img src="{{ $knockinpostproducts->first()->img_url ?? url('storage/products/default.jpg') }}"
                                 alt="{{ $knockinpostproducts->first()->product_name ?? 'Knock-in Post' }}" class="img-fluid rounded product_img">
                            <div class="mt-1">
                                Knock-in Posts
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Table -->
                <div class="col-md-9">
                    <p class="text-danger mb-1" style="font-size: 12px;"><strong>note:</strong> call ahead for local pickup!</p>
                    
                    <!-- Desktop Table (Hidden on Mobile) -->
                    <div class="d-none d-md-block">
                        <table class="table table-bordered">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Item Number</th>
                                    <th>Size</th>
                                    <th>weight_lbs</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($knockinpostproducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <span class="item-number">{{ $product->item_no }}</span>
                                            </div> 
                                        </td>
                                       
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <span>{{ $product->size }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <span>{{ $product->weight_lbs }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-select">
                                                <option selected>{{ $product->color }}</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="input-group quantity-section">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="decrementQuantity(this)">-</button>
                                                <input type="number" class="form-control form-control-sm text-center quantity-input" value="1" min="1" style="width: 50px;">
                                                <button class="btn btn-sm btn-outline-secondary" onclick="incrementQuantity(this)">+</button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span>{{ $product->price }}</span>
                                                <button class="btn btn-sm btn-danger text-white ms-2">Add to Cart</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Mobile Cards (Visible only on Mobile) -->
                    <div class="d-md-none">
                        @foreach ($knockinpostproducts as $product)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ $product->item_no }}</span>
                                        <span class="badge bg-primary">{{ $product->color }}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">Size:</div>
                                        <div class="col-6">{{ $product->size }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6 fw-bold">weight_lbs:</div>
                                        <div class="col-6">{{ $product->weight_lbs }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6 fw-bold">Price:</div>
                                        <div class="col-6">{{ $product->price }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="decrementMobileQuantity(this)">-</button>
                                            <input type="number" class="form-control form-control-sm mx-1 text-center quantity-input" value="1" min="1" style="width: 40px;">
                                            <button class="btn btn-sm btn-outline-secondary" onclick="incrementMobileQuantity(this)">+</button>
                                        </div>
                                        <button class="btn btn-sm btn-danger">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function decrementQuantity(button) {
                var input = button.nextElementSibling;
                var value = parseInt(input.value, 10);
                if (value > 1) {
                    input.value = value - 1;
                }
            }
            
            function incrementQuantity(button) {
                var input = button.previousElementSibling;
                var value = parseInt(input.value, 10);
                input.value = value + 1;
            }
            
            function decrementMobileQuantity(button) {
                var input = button.nextElementSibling;
                var value = parseInt(input.value, 10);
                if (value > 1) {
                    input.value = value - 1;
                }
            }
            
            function incrementMobileQuantity(button) {
                var input = button.previousElementSibling;
                var value = parseInt(input.value, 10);
                input.value = value + 1;
            }
        </script>
    </div>
    
@include('partials.homefooter')

@endsection

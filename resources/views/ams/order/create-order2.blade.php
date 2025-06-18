@extends('layouts.ams')

@section('title', 'Create New Order')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
<style>
    .content {
        padding:0rem;
        background-color:rgb(255, 255, 255);
    }
    .header{
        border-radius:0;
    }
    .breadcrumb-item + .breadcrumb-item::before{
        content: ">";
    }
    .card{
        border: 2px dashed rgb(165, 165, 165);
    }
    .form-control,
    .form-select {
        border-width: 2px;
        padding: .8rem 0.75rem;
    }
    .text-success{
        color:rgb(61, 163, 1) !important;
    }
    @media print {
        form{
            display: none;
        }
        .d-print-none {
           display: none;
       }
    }
</style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 d-none">
                <h1>Use the form below to create new order</h1>
                <p>Upload new install jobs to the gallery.</p>
                <button type="button" class="btn btn-primary mb-3" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Upload New Job Installation
                </button>

            </div>
        </div>

        <div class="row">
           
            <div class="col-md-8">
                <x-cart-order-status :cardHeader="'Order Status'" :cardname="'orderstatus'" />
                <x-cart-customer-search :cardHeader="'Customer Search'" :cardname="'customersearch'" />
                <x-cart-address :cardHeader="'Shipping Address'" :cardname="'shipping'" />
                <x-cart-address :cardHeader="'Billing Address'" :cardname="'billing'" :admin="true"/>
                <x-cart-items :cardHeader="'Order Items'" :cardname="'items'" />
                <x-cart-correspondence :cardHeader="'Shipping Method'" :cardname="'correspondence'" />
                <x-cart-shipping-insert-ams />
                <x-cart-payment :cardHeader="'Payment Method'" :cardname="'payment'" />
                <x-cart-activity-list :cardHeader="'Order Notes'" :cardname="'ordernotes'" />
            </div>
            <div class="col-md-4">
                <div class="card mb-4" style="border: 2px solid #b9b9b9;">
                    <div class="card-header bg-primary p-2">
                        <h4 class="card-title mb-0">Store</h4>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Welded Wire - Vinyl PVC Coated
                            </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">An item</li>
                                        <li class="list-group-item">A second item</li>
                                        <li class="list-group-item">A third item</li>
                                        <li class="list-group-item">A fourth item</li>
                                        <li class="list-group-item">And a fifth one</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Wood Fence - Treated
                            </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                     <ul class="list-group list-group-flush">
                                        <li class="list-group-item">An item</li>
                                        <li class="list-group-item">A second item</li>
                                        <li class="list-group-item">A third item</li>
                                        <li class="list-group-item">A fourth item</li>
                                        <li class="list-group-item">And a fifth one</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                Chain Link - Galvanized
                            </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">An item</li>
                                        <li class="list-group-item">A second item</li>
                                        <li class="list-group-item">A third item</li>
                                        <li class="list-group-item">A fourth item</li>
                                        <li class="list-group-item">And a fifth one</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3 cart-summary" style="background-color: #fbf7db;">
                    <div class="card-header bg-secondary p-2">
                        <h4 class="card-title mb-0 text-dark">Order Summary</h4>
                    </div>
                      <div class="cart-summary-container">
                          <ul class="list-group-item px-3 pt-4">
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Item Subtotal ({{$cart['quantity']}})</span>
                                  <span class="text-muted" data-mi-subtotal="">${{$cart['subtotal']}}</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Shipping Cost</span>
                                  <span class="text-muted shipping-cost" data-mi-shipping="">${{$cart['shipping_cost']}}</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Shipping Price</span>
                                  <span class="text-muted shipping-cost" data-mi-shipping="">${{$cart['shipping_cost']}}</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Sales Tax</span>
                                  <span class="text-muted" data-mi-taxes="0">${{$cart['tax']}}</span>
                              </li>
                              <li class="list-group-item py-1 d-flex justify-content-between">
                                  <span>Discount</span>
                                  <span class="text-muted" data-mi-taxes="0">$0</span>
                              </li>
                          </ul>
                          <div class="p-3 d-flex justify-content-between border-top">
                              <strong>Total (USD)</strong>
                              <strong class="cart-total"  data-mi-total="{{$cart['total']}}">${{$cart['total']}}</strong>
                          </div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-lg m-3 mt-0" id="place-order">
                          Place Order
                      </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add new install job</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">  
            <div class="mb-3">
                <label for="header" class="form-label">Title</label>
                <input type="text" name="header" id="header" class="form-control" placeholder="Enter header text" required>
                <div id="emailHelp" class="form-text">Title takes 160 characters.</div>
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Caption (Description)</label>
                <textarea name="caption" id="caption" class="form-control" rows="3" placeholder="Enter caption" required></textarea>
                <div id="emailHelp" class="form-text">Caption takes 255 characters.</div>
            </div>
            <div class="form-group mb-3">
                <label for="file">Upload Image:</label>
                <input type="file" name="filename" id="file" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="majorcategories_id">Category</label>
                <select name="majorcategories_id" id="majorcategories_id" class="form-select" required>
                    <!-- Add dynamic category options here -->
                    <option value="" selected>-- Select Category --</option>
                    @foreach ($majCategories as $ob)
                        <option value="{{$ob->id}}">{{$ob->cat_name}}</option>
                    @endforeach

                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="county_id">City/Town</label>
                        <select name="county_id" id="county_id" class="form-control" required>
                            <option value="">-- Select City --</option>
                            @foreach ($cities as $city)
                                <option value="{{$city->id}}">{{$city->city}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="county_id">County</label>
                        <select name="county_id" id="county_id" class="form-control" required>
                            <option value="">-- Select County --</option>
                            @foreach ($counties as $county)
                                <option value="{{$county->id}}">{{$county->county}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>




@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css">
    <style>
        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 0.5rem;
        }

        .card .card-body {
            padding: 0.5rem;
        }

        .form-control,
        .form-select {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .table> :not(caption)>*>* {
            padding: 0.25rem;
        }

        .btn-group-vertical>.btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            text-align: left;
        }
        
        @media (max-width: 767px) {
            .col-md-9, .col-md-3 {
                width: 100%;
            }
            
            .col-md-3 {
                margin-top: 1rem;
            }
        }

        /* Shipping modal styling */
        .shipping-table th, .shipping-table td {
            font-size: 0.85rem;
            padding: 0.25rem;
        }
        
        /* Order Status Styling */
        .order-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }
        
        .order-status-QUOTE {
            background-color: #FFD8B1;
            color: #000;
        }
        
        .order-status-PROCESSED {
            background-color: #C0C0C0;
            color: #000;
        }
        
        .order-status-DEPOSIT {
            background-color: #B6D7B9;
            color: #000;
        }
        
        .order-status-NEW {
            background-color: #A9D4F6;
            color: #000;
        }
        
        .order-status-PROCESSING {
            background-color: #E8B4B4;
            color: #000;
        }
        
        .order-status-MATERIAL {
            background-color: #FF5252;
            color: #fff;
        }
    </style>
@endsection

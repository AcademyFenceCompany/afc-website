{{-- @dd($orders); --}}
@extends('layouts.ams')

@section('title', 'Products Report')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('/assets/css/style.css')}}" >
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
    <div class="container-fluid admin p-4">
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
            <div class="col-md-12">
                <h1>Products Report</h1>
                <p>Product reporting provides insights into the performance, trends, and details of various products. It helps in analyzing sales, inventory, and other key metrics to make informed business decisions.</p>
                <div class="search-prod-report mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Actual search box -->
                            <div class="form-group has-search mb-3">
                                <label for="majcat_id">Search</label>
                                <i class="bi bi-search form-control-feedback"></i>
                                <input type="text" class="form-control form-control-lg" placeholder="Search by item# or product name" id="search-products" name="search-products" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="majcat_id">Select Major Category</label>
                                <select name="majcat_id" id="majcat_id" class="form-control form-control-lg" required>
                                    <option value="">-- Major Category --</option>
                                    @foreach ($majCategories as $ob)
                                        <option value="{{$ob->id}}">{{$ob->cat_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="subcat_id">Select Sub-Category</label>
                                <select name="subcat_id" id="subcat_id" class="form-control form-control-lg" required>
                                    <option value="">-- Sub Category --</option>
                                    @foreach ($subCategories as $ob)
                                        @if ($id == $ob->id)
                                            <option value="{{$ob->id}}" selected>{{$ob->cat_name}}</option>
                                        @else
                                            <option value="{{$ob->id}}">{{$ob->cat_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="result-container" id="product-report-table">
            <x-product-report :products="$products" :columnHeaders="$columnHeaders" :filters="$filters" :id="$id" :categoryqry="$categoryqry" :majCategories="$majCategories" />
        </div>

        <div class="row">
            <div>
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link" href="#">«</a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">3</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">4</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">5</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">»</a>
                  </li>
                </ul>
                <button type="button" class="btn btn-primary" id="print-prod-report">Print PDR</button>
            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen p-4 mb-4" id="modal-html">

  </div>
</div>
<!-- Carousel wrapper -->
@endsection

@section('scripts')
<script src="{{ asset('assets/js/main.js') }}"></script>
@endsection

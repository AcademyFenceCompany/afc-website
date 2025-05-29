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
                <h1>Shipping Module</h1>
                <p>Example text for shipping module</p>
                <x-shipping2-module />

            </div>
        </div>


        <div class="result-container" id="product-report-table">
            
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

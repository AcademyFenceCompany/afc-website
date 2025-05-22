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
                <h1>Activity Log</h1>
                <p class="text-muted">View and track recent activities and changes made within the system. This log helps monitor user actions and system events for better transparency and auditing.</p>
                <div class="search-prod-report mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-bg-secondary">
                                <div class="card-body">
                                    <h5 class="card-title">Orders Log</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                    <p>Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Quotes Log</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                    <p>Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-bg-danger">
                                <div class="card-body">
                                    <h5 class="card-title">Errors Log</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                                    <p>Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                                    <a href="#" class="card-link">Card link</a>
                                    <a href="#" class="card-link">Another link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="result-container">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">Activity</th>
                <th scope="col">Activity Type</th>
                <th scope="col">User</th>
                <th scope="col">File</th>
                <th scope="col">Timestamp</th>
                <th scope="col">IP</th>
                </tr>
            </thead>
            <tbody>
            @foreach($activityLog as $activity)
                <tr>
                    <td>{{$activity->note_desc}}</td>
                    <td>{{$activity->logtype_id}}</td>
                    <td>Colin Welcome</td>
                    <td>
                        @if(empty($activity->filename))
                            No File
                        @else
                            {{ $activity->filename }}
                            <a class="btn btn-outline-secondary px-2 py-1 d-print-none" href="#" role="button" onclick="App.openModal({{$activity->id}},'exampleModal')">
                    <i class="bi bi-pencil-fill"></i></a>
                        @endif
                    </td>
                    <td>{{$activity->datecreated}}</td>
                    <td>{{$activity->ip_info}}</td>
                </tr>
            @endforeach
            </tbody>
            </table>
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

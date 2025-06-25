{{-- @dd($orders); --}}
@extends('layouts.ams')

@section('title', 'Install Job Upload')
@section('styles')
<style>
    .content {
    padding:0rem;
    background-color: #f5f5f5;
    overflow-y: auto;
    }
    .header{
        border-radius:0;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid p-4">
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
                <h1>Install Jobs Gallery Upload</h1>
                <p>Upload new install jobs to the gallery.</p>
                <button type="button" class="btn btn-primary mb-3" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Upload New Job Installation
                </button>

            </div>
        </div>

        <div class="row">
            @foreach($installGallery as $install)
            <div class="col-lg-3">
                <div class="card mb-4 shadow-sm">
                <img
                    src="{{ asset('storage/install-jobs/thumbnail/' . $install->filename) }}"
                    class="card-img-top" 
                    alt="Waterfall"
                />
                <div class="card-body">
                    <h5 class="card-title">{{ Str::limit($install->header, 30) }}</h5>
                    <p class="card-text">{{$install->caption}}</p>
                    </p>
                    <a href="#!" data-mdb-ripple-init data-id="{{$install->id}}" class="btn btn-primary">Edit</a>
                </div>
                </div>
            </div>
            @endforeach

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
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="county_id">City/Town</label>
                        <select name="county_id" id="county_id" class="form-control" required>
                            <option value="">-- Select City --</option>
                            @foreach ($cities as $city)
                                <option value="{{$city->id}}">{{$city->city}} ({{$city->county}})</option>
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
<!-- Carousel wrapper -->

@endsection


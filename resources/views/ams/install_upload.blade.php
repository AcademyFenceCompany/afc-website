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
        <div class="row">
            <div class="col-md-12">
                <h1>Install Jobs Upload</h1>
                <form action="{{ route('ams.install_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Select file:</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@extends('layouts.ams')

@section('title', 'MySQL Major Categories')

@section('content')
<div class="container-fluid">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2>MySQL Major Categories (academyfence database)</h2>
        <div>
            <a href="{{ route('ams.mysql-majorcategories.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Major Category
            </a>
            <a href="{{ route('ams.mysql-categories.index') }}" class="btn btn-primary">
                <i class="bi bi-list"></i> Back to Categories
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($majorCategories as $majorCategory)
                        <tr>
                            <td>{{ $majorCategory->id }}</td>
                            <td>{{ $majorCategory->cat_name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($majorCategory->cat_desc, 100) }}</td>
                            <td>
                                @if($majorCategory->frontend)
                                    <span class="badge bg-success">Enabled</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('ams.mysql-majorcategories.edit', $majorCategory->id) }}" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $majorCategory->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $majorCategory->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $majorCategory->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $majorCategory->id }}">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the major category "{{ $majorCategory->cat_name }}"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('ams.mysql-majorcategories.destroy', $majorCategory->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No major categories found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

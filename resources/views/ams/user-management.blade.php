@extends('layouts.ams')

@section('title', 'User Management')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">User Management</h3>
                @if (auth()->user()->level === 'God')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        Add New User
                    </button>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->getFullNameAttribute() }}</td>
                                <td>{{ $user->level }}</td>
                                <td>
                                    @if (auth()->user()->level === 'God')
                                        <button class="btn btn-sm toggle-status" data-id="{{ $user->id }}"
                                            data-status="{{ $user->enabled }}">
                                            <span class="badge {{ $user->enabled ? 'bg-success' : 'bg-danger' }}">
                                                {{ $user->enabled ? 'Active' : 'Inactive' }}
                                            </span>
                                        </button>
                                    @else
                                        <span class="badge {{ $user->enabled ? 'bg-success' : 'bg-danger' }}">
                                            {{ $user->enabled ? 'Active' : 'Inactive' }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->level === 'God')
                                        <button class="btn btn-sm btn-primary edit-user" data-id="{{ $user->id }}"
                                            data-username="{{ $user->username }}" data-firstname="{{ $user->firstname }}"
                                            data-lastname="{{ $user->lastname }}" data-level="{{ $user->level }}"
                                            data-bs-toggle="modal" data-bs-target="#editUserModal">
                                            Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}">
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Level</label>
                            <select name="level" class="form-control" required>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                                <option value="God">God</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Level</label>
                            <select name="level" class="form-control" required>
                                <option value="Staff">Staff</option>
                                <option value="Admin">Admin</option>
                                <option value="God">God</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

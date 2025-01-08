@extends('layouts.ams')

@section('title', 'User Management')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Management</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Last Login</th>
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
                                    <span class="badge {{ $user->enabled ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->enabled ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $user->last_login }}</td>
                                <td>
                                    @if (auth()->user()->level === 'God')
                                        <button class="btn btn-sm btn-primary edit-user" data-id="{{ $user->id }}"
                                            data-username="{{ $user->username }}" data-firstname="{{ $user->firstname }}"
                                            data-lastname="{{ $user->lastname }}" data-level="{{ $user->level }}"
                                            data-bs-toggle="modal" data-bs-target="#editUserModal">
                                            Edit
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                <form id="editUserForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
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
                            <select name="level" id="level" required>
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

<script src="{{ asset('js/user-management.js') }}"></script>

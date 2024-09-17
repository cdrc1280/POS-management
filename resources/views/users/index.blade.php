@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float: left;">Add User</h4>
                        <a href="#" style="float: right;" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#addUser">
                            <i class="fa fa-plus"></i> Add New User
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @if ($user->is_admin == 1)
                                                Admin
                                            @else
                                                Cashier
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editUser{{ $user->id }}" class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUser{{ $user->id }}" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>


                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal of editing new user --}}
                                    <div class="modal right fade" id="editUser{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="editUserLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                    {{-- {{ $user->id }} --}}
                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <input type="text" name="name" id=""
                                                                class="form-control" value="{{ $user->name }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="email" name="email" id=""
                                                                class="form-control" value="{{ $user->email }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Phone</label>
                                                            <input type="text" id="" name="phone"
                                                                class="form-control" value="{{ $user->phone }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Password</label>
                                                            <input type="password" name="password" id=""
                                                                class="form-control" value="{{ $user->password }}"
                                                                readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">Role</label>
                                                            <select name="is_admin" id="" class="form-control">
                                                                <option value="1"
                                                                    @if ($user->is_admin == 1) selected @endif>Admin
                                                                </option>
                                                                <option value="2"
                                                                    @if ($user->is_admin == 2) selected @endif>
                                                                    Cashier
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary btn-block">Update User</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal for deleting user --}}
                                    <div class="modal right fade" id="deleteUser{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="deleteUserLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteUserLabel">Delete User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <p>Are you sure you want to delete {{ $user->name }}?</p>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-warning"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex justify-content-right">
                            {{ $users->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Search User</h4>
                    </div>
                    <div class="card-body">
                        <h5>Hello</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal of adding new user --}}
    <div class="modal right fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" id="" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="text" id="" name="phone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm_password" id="" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="">Role</label>
                            <select name="is_admin" id="" class="form-control" required>
                                <option value="1">Admin</option>
                                <option value="2">Cashier</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary btn-block">Save User</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

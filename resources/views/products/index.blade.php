@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float: left;">Add Product</h4>
                        <a href="#" style="float: right;" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#addProduct">
                            <i class="fa fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Selling Price</th>
                                    <th>Quantity</th>
                                    <th>Alert Stock</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $products->firstItem() + $key }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->brand }}</td>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            @if ($product->alert_stock <= $product->quantity)
                                                <span class="badge bg-danger">Low Stock: {{ $product->alert_stock }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $product->alert_stock }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->description }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editProduct{{ $product->id }}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteProduct{{ $product->id }}"
                                                    class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal for editing product --}}
                                    <div class="modal right fade" id="editProduct{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="editProductLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('products.update', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="product_name">Product Name</label>
                                                            <input type="text" name="product_name" class="form-control"
                                                                value="{{ $product->product_name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="brand">Brand</label>
                                                            <input type="text" name="brand" class="form-control"
                                                                value="{{ $product->brand }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">Price</label>
                                                            <input type="number" name="price" class="form-control"
                                                                value="{{ $product->price }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="quantity">Quantity</label>
                                                            <input type="number" name="quantity" class="form-control"
                                                                value="{{ $product->quantity }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="alert_stock">Alert Stock</label>
                                                            <input type="number" name="alert_stock" class="form-control"
                                                                value="{{ $product->alert_stock }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description">Description</label>
                                                            <textarea name="description" class="form-control" rows="2">{{ $product->description }}</textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Product</button>
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Modal for deleting product --}}
                                    <div class="modal right fade" id="deleteProduct{{ $product->id }}" tabindex="-1"
                                        aria-labelledby="deleteProductLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteProductLabel">Delete Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <p>Are you sure you want to delete {{ $product->product_name }}?
                                                        </p>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                            <button type="button" class="btn btn-warning"
                                                                data-bs-dismiss="modal">Cancel</button>
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
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Search Product</h4>
                    </div>
                    <div class="card-body">
                        <h5>Hello</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for adding new product --}}
    <div class="modal right fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" class="form-control" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="alert_stock">Alert Stock</label>
                            <input type="number" name="alert_stock" class="form-control" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

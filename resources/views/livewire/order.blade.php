<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 style="float: left;">Ordered Products</h4>
                <a href="#" style="float: right;" class="btn btn-light" data-bs-toggle="modal"
                    data-bs-target="#addProduct">
                    <i class="fa fa-plus"></i> Add New Product
                </a>
            </div>

            <div class="card-body">
                @csrf
                <div class="my-2">
                    <form wire:submit.prevent="insertToCart">
                        <input type="text" wire:model="product_code" name="product_code" class="form-control"
                            placeholder="Enter Product Code">
                    </form>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session()->has('info'))
                    <div class="alert alert-info">
                        {{ session('info') }}
                    </div>
                @elseif (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount (%)</th>
                            <th>Total</th>
                            <th>
                                <a href="#" class="btn btn-sm btn-primary rounded-circle">
                                    <i class="fa fa-plus-circle add_more"></i>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="addMoreProduct">
                        @foreach ($productInCart as $key => $cart)
                            <tr>
                                <td class="no">{{ $key + 1 }}</td>
                                <td width="30%">
                                    <input type="text" value="{{ $cart->product->product_name }}"
                                        class="form-control">
                                </td>
                                <td width="15%">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-success"
                                                wire:click.prevent="incrementQty({{ $cart->id }})">+</button>
                                        </div>
                                        <div class="col-md-1">
                                            <label for="">{{ $cart->product_qty }}</label>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-sm btn-danger"
                                                wire:click.prevent="decrementQty({{ $cart->id }})">-</button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" class="form-control" min="0" readonly
                                        value="{{ $cart->product->price }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" min="0" readonly
                                        value="{{ $cart->product_qty * $cart->product->price }}">
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-danger rounded-circle"
                                        wire:click="removeProduct({{ $cart->id }})">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4>Total <b class="total">{{ $productInCart->sum('product_price') }}</b></h4>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    @foreach ($productInCart as $key => $cart)
                        <input type="hidden" class="form-control" name="product_id[]"
                            value="{{ $cart->product->id }}">

                        <input type="hidden" name="quantity[]" value="{{ $cart->product_qty }}">

                        <input type="hidden" class="form-control price" name="price[]"
                            value="{{ $cart->product_qty * $cart->product->price }}">

                        <input type="hidden" class="form-control discount" name="discount[]">

                        <input type="hidden" name="total_amount[]" id="total_amount" class="form-control total_amount"
                            value="{{ $cart->product_qty * $cart->product->price }}">
                    @endforeach

                    <button type="button" class="btn btn-dark" onclick="PrintReceiptContent('print')">Print
                        <i class="fa fa-print"></i>
                    </button>

                    <button type="button" class="btn btn-primary" onclick="">History
                        <i class="fa fa-clock"></i>
                    </button>

                    <button type="button" class="btn btn-danger" onclick="">Report
                        <i class="fa fa-print"></i>
                    </button>

                    <div class="panel">
                        <table class="table table-striped">
                            <tr>
                                <td>
                                    <label for="">Customer Name</label>
                                    <input type="text" name="customer_name" class="form-control">
                                </td>
                                <td>
                                    <label for="">Customer Number</label>
                                    <input type="number" name="customer_phone" class="form-control">
                                </td>
                            </tr>
                        </table>

                        <div class="mt-5">
                            Payment Method <br>
                            <span class="radio-item">
                                <input type="radio" name="payment_method" id="payment_method" class="true"
                                    value="cash" checked="checked">
                                <label for="payment_method">
                                    <i class="fa fa-money-bill text-success"></i> Cash
                                </label>
                            </span>

                            <span class="radio-item">
                                <input type="radio" name="payment_method" id="payment_method" class="true"
                                    value="bank_transfer">
                                <label for="payment_method">
                                    <i class="fa fa-university text-primary"></i> Bank Transfer
                                </label>
                            </span>

                            <span class="radio-item">
                                <input type="radio" name="payment_method" id="payment_method" class="true"
                                    value="credit_card">
                                <label for="payment_method">
                                    <i class="fa fa-credit-card text-danger"></i> Credit Card
                                </label>
                            </span>
                        </div><br>

                        <div>
                            Payment <br>
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control"
                                wire:model="pay_money">
                        </div>

                        <div>
                            Returning Change <br>
                            <input type="number" name="balance" id="balance" class="form-control" readonly
                                wire:model="balance">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary btn-block mt-3 btn-lg w-100">Save</button>
                        </div><br>

                        <div>
                            <button class="btn btn-danger btn-block mt-2 btn-lg w-100">Calculator</button>
                        </div><br>

                        <div class="text-center" style="text-align:center !important">
                            <a href="#" class="text-danger text-center">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

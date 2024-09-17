@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @livewire('order')
    </div>

    {{-- Modal for adding new product --}}
    <div class="modal right fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Order orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('orders.store') }}" method="POST">
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
                            <input type="number" name="price" class="form-control" required min="0" readonly>
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

    <div class="modal">
        <div id="print">
            @include('reports.receipt')
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Function to calculate and update total amount
            function totalAmount() {
                let total = 0;
                $('.total_amount').each(function() {
                    let amount = parseFloat($(this).val()) || 0;
                    total += amount;
                });
                $('.total').html(total.toFixed(2));
            }

            // Add more product rows
            $('.add_more').on('click', function() {
                let product = $('.product_id').html();
                let numberOfRow = ($('.addMoreProduct tr').length) + 1;
                let tr = '<tr><td class="no">' + numberOfRow + '</td>' +
                    '<td> <select class="form-control product_id" name="product_id[]">' + product +
                    ' </select></td>' +
                    '<td> <input type="number" name="quantity[]" class="form-control quantity" min="0"></td>' +
                    '<td> <input type="number" name="price[]" class="form-control price" min="0"></td>' +
                    '<td> <input type="number" name="discount[]" class="form-control discount" min="0"> </td>' +
                    '<td> <input type="number" name="total_amount[]" class="form-control total_amount" min="0"></td>' +
                    '<td> <a href="#" class="btn btn-sm btn-danger delete rounded-circle"><i class="fa fa-times-circle delete"></i></a> </td>' +
                    '</tr>';
                $('.addMoreProduct').append(tr);
            });

            // Delegate function to handle changes in product_id select
            $('.addMoreProduct').delegate('.product_id', 'change', function() {
                let tr = $(this).closest('tr');
                let price = tr.find('.product_id option:selected').attr('data-price');
                tr.find('.price').val(price);

                let qty = parseFloat(tr.find('.quantity').val()) || 0;
                let disc = parseFloat(tr.find('.discount').val()) || 0;
                let priceVal = parseFloat(tr.find('.price').val()) || 0;

                let total_amount = (qty * priceVal) - disc;
                tr.find('.total_amount').val(total_amount.toFixed(2));

                totalAmount();
            });

            // Delegate function to handle quantity, price, or discount change
            $('.addMoreProduct').delegate('.quantity, .price, .discount', 'keyup change', function() {
                let tr = $(this).closest('tr');
                let qty = parseFloat(tr.find('.quantity').val()) || 0;
                let disc = parseFloat(tr.find('.discount').val()) || 0;
                let priceVal = parseFloat(tr.find('.price').val()) || 0;

                let total_amount = (qty * priceVal) - disc;
                tr.find('.total_amount').val(total_amount.toFixed(2));

                totalAmount();
            });

            // Delegate function to handle row deletion
            $('.addMoreProduct').delegate('.delete', 'click', function() {
                $(this).closest('tr').remove();
                totalAmount();
            });


            $('.addMoreProduct').on('.quantity', '.discount', 'keyup', function() {
                let tr = $(this).parent().parent();
                let qty = tr.find('.quantity').val() - 0;
                let disc = tr.find('.discount').val() - 0;
                let price = tr.find('.price').val() - 0;
                let total_amount = (qty * priceVal) - disc;
                tr.find('.total_amount').val(totalAmount);
                totalAmount();
            });

            $("#paid_amount").on('keyup', function() {

                let total = parseFloat($('.total').html());
                let paid_amount = parseFloat($(this).val());

                let balance = paid_amount - total;

                $('#balance').val(balance.toFixed(2));
            });



        });

        function PrintReceiptContent(el) {
            let element = document.getElementById(el);

            if (!element) {
                console.error(`Element with id '${el}' not found.`);
                return;
            }

            let data = '<input type="button" id="printPageButton" ' +
                'class="printPageButton" style="display: block; ' +
                'width: 100%; border: none; background-color: #008B8B; color: #fff; ' +
                'padding: 14px 28px; font-size: 1rem; cursor: pointer; text-align: center;" ' +
                'value="Print Receipt" onClick="window.print()">';

            data += element.innerHTML;
            let myReceipt = window.open("", "myWin", "left=170, top=150, width=500, height=500");
            myReceipt.screenX = 0;
            myReceipt.screenY = 0;
            myReceipt.document.write(data);
            myReceipt.document.title = "Print Receipt";
            myReceipt.focus();
            setTimeout(() => {
                myReceipt.close();
            }, 20000);
        }
    </script>
@endsection

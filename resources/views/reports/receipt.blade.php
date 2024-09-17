<head>
    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgb(0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 58mm;
            background: #fff;
        }

        #invoice-POS::selection {
            background: #f315f3;
            color: #fff;
        }

        #invoice-POS::-moz-selection {
            background: #34495e;
            color: #fff;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
        }

        #invoice-POS h2 {
            font-size: 1em;
        }

        #invoice-POS p {
            font-size: 0.7em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS #top,
        #invoice-POS #mid,
        #invoice-POS #bot {
            border-bottom: 1px #eee solid;
        }

        /* #invoice-POS #top {
            min-height: 100px;
        } */

        #invoice-POS #mid {
            min-height: 80px;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .loWWgo {
            height: 60px;
            width: 60px;
            background: url() no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        #invoice-POS .info {
            display: block;
            margin-left: 0;
            text-align: center;
        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tableTitle {
            font-size: 0.5em;
            background: #eee;
            border-top: 1px black solid;
            border-bottom: 1px black solid
        }

        #invoice-POS .service {
            border-bottom: 1px solid #eee;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .itemText {
            font-size: 0.5rem;
        }

        #invoice-POS #legalCopy {
            margin-top: 5mm;
            text-align: center;
        }

        .serial-number {
            margin: 5mm auto 2mm auto;
            text-align: center;
            font-size: 12px;
        }

        .serial {
            font-size: 10px !important;
        }
    </style>
</head>

<body>
    <!-- Print Section -->
    <div id="invoice-POS">
        <div id="printed-content">
            <center id="top">
                {{-- <div class="logo">MUNS</div> --}}
                <p>
                    Hillsdale Angono, Rizal
                </p>
                <div class="d-flex">
                    <p>07/25/2024</p>
                    <p>2:32 PM</p>
                </div>
                <p>VAT Req: TIN: 00000000</p>
                <p>SN: 0000000000000000</p>

                {{-- <div class="info"></div>
                <h2>MUNS CHILLOUT</h2>
                <p>
                    Email: test@gmail.com
                    Phone: 09876543098
                </p> --}}
                <h2>Contact Us</h2>

            </center>
        </div>

        <div id="mid">
            <div class="info">
                <h2><strong>SALES INVOICE</strong></h2>
                <p>
                    Name: Test name
                    Address: Test address

                    TIN:000000000
                    Business Styles:000000
                </p>
                <p>====================================</p>
                <p>TABLE # 1</p>
                <p>Customer Name</p>
                <p>====================================</p>
                <p>DINE IN</p>
                <p>Cashier Number: Test cashier</p>
                <p>Transactions #: 0000000</p>
                <p># of Customers: 0</p>
            </div>
        </div>
        <!-- End of Mid Print -->

        <div id="bot">
            <div id="table">

                <table>

                    <tr class="tableTitle">
                        <td class="qty">
                            <h2>Qty</h2>
                        </td>
                        <td class="item">
                            <h2>Description</h2>
                        </td>
                        <td class="unit">
                            <h2>Unit Price</h2>
                        </td>

                        <td class="discount">
                            <h2>Discount</h2>
                        </td>
                        <td class="subTotal">
                            <h2>Sub Total</h2>
                        </td>
                    </tr>


                    @foreach ($orders_receipt as $receipt)
                        <tr class="service">
                            <td class="tableItem">
                                <p class="itemText">{{ $receipt->quantity }}</p>
                            </td>
                            <td class="tableItem">
                                <p class="itemText">{{ $receipt->product->product_name }}</p>
                            </td>
                            <td class="tableItem">
                                <p class="itemText">{{ number_format($receipt->unit_price, 2) }}</p>
                            </td>

                            <td class="tableItem">
                                <p class="itemText">{{ number_format($receipt->dicount ? '' : 0, 2) }}</p>
                            </td>
                            <td class="tableItem">
                                <p class="itemText">{{ number_format($receipt->amount, 2) }}</p>
                            </td>
                        </tr>
                    @endforeach

                    {{-- <tr class="tableTitle">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rate">
                            <p class="itemText">Tax</p>
                        </td>
                        <td class="payment">
                            <p class="itemText"> Sub Total: <strong>{{ number_format($receipt->amount, 2) }}</strong>
                            </p>
                        </td>
                    </tr> --}}

                    <tr class="tableTitle">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rate">
                            <p class="itemText">Total</p>
                        </td>
                        <td class="payment">
                            <h2>{{ number_format($orders_receipt->sum('amount'), 2) }}</h2>
                        </td>
                        {{-- <td class="paid_amount">
                            <h2>{{ number_format($orders_receipt->payment_method, 2) }}</h2>
                        </td>
                        <td class="paid_amount">
                            <h2>{{ number_format($orders_receipt->balance, 2) }}</h2>
                        </td> --}}
                    </tr>
                </table>

                <div class="legalCopy">
                    <p class="legal">
                        <strong>** Thank you for visiting us **</strong>
                        <br />
                        The goods which are subject to tax, price includes
                    </p>
                    <div class="serial-number">
                        Serial: <span class="serial">1234567890</span>
                        <span>24/14/2020 &nbsp; &nbsp; 00:45 </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

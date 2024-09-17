<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $products = Product::all();
    //     $orders = Order::all();

    //     // Last Order Details
    //     $lastID = OrderDetail::max('order_id');
    //     $orders_receipt = OrderDetail::where('order_id', $lastID)->get();
    //     // return $orders_receipt;


    //     return view(
    //         'orders.index',
    //         [
    //             'products' => $products,
    //             'orders' => $orders,
    //             'orders_receipt' => $orders_receipt
    //         ]
    //     );
    // }

    public function index()
    {
        $products = Product::all();
        $orders = Order::all();

        // Last Order Details
        $lastID = OrderDetail::max('order_id');

        // Get only the last order detail for the last order ID
        $orders_receipt = OrderDetail::where('order_id', $lastID)->get();

        return view(
            'orders.index',
            [
                'products' => $products,
                'orders' => $orders,
                'orders_receipt' => $orders_receipt
            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function store(Request $request)
    {
        // return $request->all();


        DB::transaction(function () use ($request) {

            // Order Modal
            $orders = new Order;
            $orders->name = $request->customer_name;
            $orders->phone = $request->customer_phone;
            $orders->save();
            $order_id = $orders->id;

            // Order Details Modal
            for ($product_id = 0; $product_id < count($request->product_id); $product_id++) {
                $orders_details = new OrderDetail;
                $orders_details->order_id = $order_id;
                $orders_details->product_id = $request->product_id[$product_id];
                $orders_details->unit_price = $request->price[$product_id];
                $orders_details->quantity = $request->quantity[$product_id];
                $orders_details->discount = $request->discount[$product_id];
                $orders_details->amount = $request->total_amount[$product_id];
                $orders_details->save();
            }

            // Transaction Modal
            $transaction = new Transaction;
            $transaction->order_id = $order_id;
            $transaction->user_id = auth()->user()->id;

            $transaction->balance = $request->balance;
            $transaction->paid_amount = $request->paid_amount;
            $transaction->payment_method = $request->payment_method;
            $transaction->transac_amount = $orders_details->amount;
            $transaction->transac_date = date('Y-m-d');
            $transaction->save();

            Cart::truncate();

            // Last Order History
            $products = Product::all();
            $orders_details = OrderDetail::where('order_id', $order_id)->get();
            $orderedBy = Order::where('id', $order_id)->get();

            return view(
                'orders.index',
                [
                    'products' => $products,
                    'orderdetails' => $orders_details,
                    'customer_orders' => $orderedBy
                ]
            );
            // return view(
            //     'orders.index',
            //     [
            //         'products' => $products,
            //         'orderdetails' => $orders_details,
            //         'customer_orders' => $orderedBy
            //     ]
            // );
        });


        return back()->with("Product orders fails to insert! Check your inputs");


    }



}
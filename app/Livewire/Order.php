<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Livewire\Component;

class Order extends Component
{
    public $orders, $products = [], $product_code, $message = '', $productInCart;

    public $pay_money = '', $balance = '';

    public $addQty;

    public function mount()
    {
        $this->products = Product::all();
        $this->productInCart = Cart::where('user_id', auth()->id())->get();
    }

    public function insertToCart()
    {
        // Using product_code to find the product
        $countProduct = Product::where('id', $this->product_code)->first();

        if (!$countProduct) {
            $this->message = 'Product not found';
            return;
        }

        // Check if the product is already in the cart for this user
        $cartItem = Cart::where('product_id', $countProduct->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($cartItem) {
            $this->message = 'Product ' . $countProduct->product_name . ' already exists in the cart. Please update the quantity.';
            return;
        }

        // Add the product to the cart
        $add_to_cart = new Cart;
        $add_to_cart->product_id = $countProduct->id;
        $add_to_cart->product_qty = 1;
        $add_to_cart->product_price = $countProduct->price;
        $add_to_cart->user_id = auth()->user()->id;
        $add_to_cart->save();

        // Refresh the cart data
        $this->productInCart = Cart::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();

        // Clear the product code input
        $this->product_code = '';

        // Set the success message
        $this->message = 'Product Added Successfully!';
    }


    public function incrementQty($cartId)
    {
        $carts = Cart::find($cartId);

        $carts->increment('product_qty', 1);
        $updatePrice = $carts->product_qty * $carts->product->price;
        $carts->update(['product_price' => $updatePrice]);
        $this->mount();
    }

    public function decrementQty($cartId)
    {
        $carts = Cart::find($cartId);

        if ($carts->product_qty == 1) {
            return session()->flash('info', 'Product ' . $carts->product_name . ' Quantity can not be less than 1, add quantity or remove product in cart');
        }

        $carts->decrement('product_qty', 1);
        $updatePrice = $carts->product_qty * $carts->product->price;
        $carts->update(['product_price' => $updatePrice]);
        $this->mount();
    }

    public function removeProduct($cartId)
    {
        $deleteCart = Cart::find($cartId);
        $deleteCart->delete();


        $this->message = "Product Removed from the cart";

        $this->productInCart = $this->productInCart->except($cartId);
    }

    public function render()
    {


        if ($this->pay_money != '') {
            $total_amount = $this->pay_money - $this->productInCart->sum('product_price');

            $this->balance = $total_amount;
        }


        return view('livewire.order');
    }
}

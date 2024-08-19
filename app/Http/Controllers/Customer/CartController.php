<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function show(Request $request)
    {
        $customer = $request->customer;

        $favourites = $customer->favourites()->pluck('id')->toArray();
        $nrOfCartProducts = $customer->getNumberOfCartProducts();
        $cart = $customer->shoppingCart()->with('product')->get();

        return view('customer.cart.index', compact('cart', 'favourites', 'nrOfCartProducts'));
    }

    public function incrementCartItemQuantity(Request $request, Product $product)
    {
        $getHtml = $request->getHtml;
        $customer = $request->customer;

        $status = $customer->incrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "incremented" ? "Product added to cart!" : "Only $product->Stock left in stock!";
        $statusCode = $status === "incremented" ? 200 : 400;

        if ($getHtml === "false") {
            $data = compact('nrOfCartProducts');
        } else {
            $cart = $status === "incremented" ? $customer->shoppingCart()->with('product')->get() : [];
            $html = $status === "incremented" ? view('customer.cart.products', compact('cart'))->render() : '';
            $data = compact('html', 'nrOfCartProducts');
        }

        return response()->json(compact('status', 'message', 'data'), $statusCode);

    }

    public function decrementCartItemQuantity(Request $request, Product $product)
    {
        $customer = $request->customer;

        $status = $customer->decrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "decremented" ? "Product quantity decreased!" : ($status === "fail" ? "Product not found!" : "Minimum quantity is 1!");
        $statusCode = $status === "decremented" ? 200 : 400;
        $cart = $status === "decremented" ? $customer->shoppingCart()->with('product')->get() : [];
        $html = $status === "decremented" ? view('customer.cart.products', compact('cart'))->render() : '';
        $data = compact('html', 'nrOfCartProducts');

        return response()->json(compact('status', 'message', 'data'), $statusCode);
    }


    public function deleteItem(Request $request, Product $product)
    {
        $customer = $request->customer;

        $status = $customer->removeFromCart($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === 'fail' ? 'Product not found in cart!' : 'Product deleted from cart!';
        $statusCode = $status === 'fail' ? 400 : 200;
        $cart = $status === 'fail' ? [] : $customer->shoppingCart()->with('product')->get();
        $html = $status === 'fail' ? '' : view('customer.cart.products', compact('cart'))->render();
        $data = compact('html', 'nrOfCartProducts');

        return response()->json(compact('status', 'message', 'data'), $statusCode);
    }

}

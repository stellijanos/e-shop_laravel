<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $customer = $request->customer;

        $status = $customer->incrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();
        $cartItem = $customer->getCartItem($product);

        $message = $status === "incremented" ? "Product added to cart!" : "Only $product->Stock left in stock!";
        $statusCode = $status === "incremented" ? 200 : 400;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrOfCartProducts' => $nrOfCartProducts,
                'cartItem' => $cartItem
            ]
        ], $statusCode);

    }
    public function decrementCartItemQuantity(Request $request, Product $product)
    {

        $customer = $request->customer;
        $status = $customer->decrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();
        $cartItem = $customer->getCartItem($product);

        $message = $status === "decremented" ? "Product quantity decreased!" : ($status === "fail" ? "Product not found!" : "Minimum quantity is 1!");
        $statusCode = $status === "decremented" ? 200 : 400;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrOfCartProducts' => $nrOfCartProducts,
                'cartItem' => $cartItem
            ]
        ], $statusCode);
    }



    public function addToCart(Product $product, int $quantity)
    {
        if (!$product) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Product not found!'
            ], 404);
        }

        $customer = Customer::getCustomer(Auth::user()->id);

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not a customer!'
            ], 401);
        }

        $status = $customer->addToCart($product, $quantity);

        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "fail" ? "Invalid quantity!" : "Product added to cart!";
        $statusCode = $status === "fail" ? 400 : 200;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrCartProducts' => $nrOfCartProducts,
            ]
        ], $statusCode);
    }

    public function deleteItem(Request $request, Product $product)
    {

        $customer = $request->customer;

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not logged in!'
            ], 401);
        }

        $status = $customer->removeFromCart($product);

        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "fail" ? 'Product not found in cart!' : 'Product deleted from cart!';

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrOfCartProducts' => $nrOfCartProducts,
            ]
        ]);

    }

}
<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    public function incrementCartItemQuantity(Request $request, Product $product)
    {
        $customer = $request->customer;

        $status = $customer->incrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = "Product added to cart!";
        $statusCode = $status === "fail" ? 400 : 200;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrOfCartProducts' => $nrOfCartProducts,
            ]
        ], $statusCode);

    }
    public function decrementCartItemQuantity(Request $request, Product $product)
    {

        $customer = $request->customer;

        $status = $customer->incrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = "Product added to cart!";
        $statusCode = $status === "fail" ? 400 : 200;

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'nrOfCartProducts' => $nrOfCartProducts,
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

    public function delteFromCart(Product $product)
    {
        if (!$product) {
            if (!$product) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Product not found!'
                ], 404);
            }
        }

        $customer = Customer::getCustomer(Auth::user()->id);

        if (!$customer) {
            return response()->json([
                'status' => 'fail',
                'message' => 'You are not logged in!'
            ], 401);
        }

        $response = $customer->removeFromCart($product);

        return response()->json($response);

    }

}

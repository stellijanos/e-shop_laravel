<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Voucher;
use App\Utils\Response;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function show(Request $request)
    {
        /** @var Customer $customer */
        $customer = $request->customer;

        $favourites = $customer->favourites()->pluck('id')->toArray();
        $nrOfCartProducts = $customer->getNumberOfCartProducts();
        $cart = $customer->shoppingCart()->with('product')->get();
        $voucher = $customer->getCartVoucher();

        // dd($voucher);

        return view('customer.cart.index', compact('cart', 'favourites', 'nrOfCartProducts', 'voucher'));
    }

    public function incrementCartItemQuantity(Request $request, Product $product)
    {

        $getHtml = $request->getHtml;

        /** @var Customer $customer */
        $customer = $request->customer;
        $voucher = $customer->getCartVoucher();

        $status = $customer->incrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "incremented" ? "Product added to cart!" : "Only $product->Stock left in stock!";
        $statusCode = $status === "incremented" ? 200 : 400;

        if ($getHtml === "false") {
            $data = compact('nrOfCartProducts');
        } else {
            $cart = $status === "incremented" ? $customer->shoppingCart()->with('product')->get() : [];
            $html = $status === "incremented" ? view('customer.cart.products', compact('cart', 'voucher'))->render() : '';
            $data = compact('html', 'nrOfCartProducts');
        }

        return (new Response($status, $message, $statusCode, $data))->get();
    }

    public function decrementCartItemQuantity(Request $request, Product $product)
    {
        /** @var Customer $customer */
        $customer = $request->customer;
        $voucher = $customer->getCartVoucher();

        $status = $customer->decrementCartItemQuantity($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === "decremented" ? "Product quantity decreased!" : ($status === "fail" ? "Product not found!" : "Minimum quantity is 1!");
        $statusCode = $status === "decremented" ? 200 : 400;
        $cart = $status === "decremented" ? $customer->shoppingCart()->with('product')->get() : [];
        $html = $status === "decremented" ? view('customer.cart.products', compact('cart', 'voucher'))->render() : '';
        $data = compact('html', 'nrOfCartProducts');

        return (new Response($status, $message, $statusCode, $data))->get();
    }


    public function deleteItem(Request $request, Product $product)
    {
        /** @var Customer $customer */
        $customer = $request->customer;
        $voucher = $customer->getCartVoucher();

        $status = $customer->removeFromCart($product);
        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        $message = $status === 'fail' ? 'Product not found in cart!' : 'Product deleted from cart!';
        $statusCode = $status === 'fail' ? 400 : 200;
        $cart = $status === 'fail' ? [] : $customer->shoppingCart()->with('product')->get();
        $html = $status === 'fail' ? '' : view('customer.cart.products', compact('cart', 'voucher'))->render();
        $data = compact('html', 'nrOfCartProducts');

        return (new Response($status, $message, $statusCode, $data))->get();
    }


    public function addVoucher(Request $request)
    {
        /** @var Customer $customer */
        $customer = $request->customer;

        /** @var Voucher $voucher */
        $voucher = $request->voucher;
        $status = $customer->applyVoucher($voucher);
        

        $message = $status === 'fail' ? 'Some error occured!' : 'Voucher applied to cart!';
        $statusCode = $status === 'fail' ? 400 : 200;
        $cart = $status === 'fail' ? [] : $customer->shoppingCart()->with('product')->get();
        $html = $status === 'fail' ? '' : view('customer.cart.products', compact('cart', 'voucher'))->render();
        $data = compact('html');

        return (new Response($status, $message, $statusCode, $data))->get();

    }

}

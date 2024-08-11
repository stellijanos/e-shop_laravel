<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        return view('account.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|max:255',
        ]);


        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }


        if ($request->email !== Auth::user()->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);
        }


        Auth::user()->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone
        ]);


        $request->session()->flash('status', 'Account updated successfully!');
        return redirect()->route('account.edit');
    }


    /**
     * Show the form for deleting the specified resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function delete()
    {
        return view('account.delete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255'
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is incorrect.']);
        }

        Auth::user()->delete();
        return redirect()->route('home');
    }


    public function toggleFavourite(Product $product)
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
                'message' => 'You are not logged in!'
            ], 401);
        }

        $status = $customer->toggleFavourite($product);
        $message = $status === "added" ? "Product added to favourites!" : "Product removed from favourites!";

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);

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
                'message' => 'You are not logged in!'
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


    public function incrementCartItemQuantity(Product $product)
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
                'message' => 'You are not logged in!'
            ], 401);
        }

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
    public function decrementCartItemQuantity(Product $product)
    {

    }







    // public function changeQuantity(Product $product, int $quantity)
    // {
    //     if (!$product) {
    //         return response()->json('not-found');
    //     }

    //     $customer = Customer::getCustomer(Auth::user()->id);

    //     if (!$customer) {
    //         return response()->json('customer-not-found');
    //     }

    //     $response = $customer->setCartProductQuantity($product, $quantity);

    //     if ($response !== "success") {
    //         return response()->json($response);
    //     }

    //     $cart = $customer->shoppingCart()->with('product')->get();
    //     return view('home.cart.products', compact('cart'));
    // }
}

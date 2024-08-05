<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ShoppingCartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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


    public function favourite(Product $product)
    {
        if (!$product) {
            return response()->json(['response' => 'not-found']);
        }
        $response = Auth::user()->addFavourite($product);
        response()->json(['response' => $response]);
    }


    public function updateShowFavourites(Product $product)
    {

    }

    public function addToCart(Product $product)
    {
        if (!$product) {
            return response()->json(['response' => 'not-found']);
        }
        Auth::user()->addToCart($product);
        return response()->json(['response' => 'added']);
    }


    public function changeQuantity(Product $product, int $quantity)
    {
        if (!$product) {
            return response()->json('not-found');
        }

        if (!$quantity < 0) {
            return response()->json('invalid-quantity');
        }

        $response = Auth::user()->setCartProductQuantity($product, $quantity);

        if ($response !== "success") {
            return response()->json($response);
        }

        $cart = Auth::user()->shoppingCart()->with('product')->get();
        return view('home.cart.products', compact('cart'));
    }
}

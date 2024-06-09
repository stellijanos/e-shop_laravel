<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $products = Product::paginate(24);
        $favourites = Auth::user()->favourites->pluck('id')->toArray();
        return view('home.index', compact('products', 'favourites'));
    }


    public function products() {
        $products = Product::paginate(24);
        $favourites = Auth::user()->favourites->pluck('id')->toArray();
        return view('home.products', compact('products', 'favourites'));
    }
}

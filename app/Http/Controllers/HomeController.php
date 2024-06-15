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
    public function index($sort_by = '')
    {

        $products = Product::paginate(24);
        $favourites = Auth::user()->favourites->pluck('id')->toArray();
        return view('home.index', compact('products', 'favourites'));
    }


    public function products($sort_by) {
        $sort_by_array = explode('-', $sort_by);
        $sort_by_keys = ['price'];
        $sort_by_values = ['asc', 'desc'];

        $key = (in_array($sort_by_array[0], $sort_by_keys)) ? $sort_by_array[0] : 'price';
        $value = (in_array($sort_by_array[1], $sort_by_values)) ? $sort_by_array[1] : 'asc';

        $products = Product::orderBy($key, $value)->paginate(24);
        $favourites = Auth::user()->favourites->pluck('id')->toArray();
        return view('home.products', compact('products', 'favourites', 'sort_by'));
    }
}

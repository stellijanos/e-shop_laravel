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
    public function index(Request $request)
    {
        $sort_by = $request->input('sort_by', 'price-asc');
        $per_page = (int) $request->input('per_page', 6);

        $per_page_values = [2, 4, 6, 8];
        $per_page = in_array($per_page, $per_page_values) ? $per_page : 6;

        $sort_by_values = ['price-asc', 'price-desc'];
        $sort_by = in_array($sort_by, $sort_by_values) ? $sort_by :$sort_by_values[0];
    
        $sort_by_array = explode('-', $sort_by);

        $key =  $sort_by_array[0];
        $value = $sort_by_array[1];

        $products = Product::orderBy($key, $value)->paginate($per_page)->appends($request->except('page'));;
        $favourites = Auth::user()->favourites->pluck('id')->toArray();

        return view('home.index', compact('products', 'favourites', 'sort_by', 'per_page', 'per_page_values'));
    }

}

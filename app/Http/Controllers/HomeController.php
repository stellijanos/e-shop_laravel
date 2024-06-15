<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpec;
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
        $search = $request->input('search', '');

        $per_page_values = [2, 4, 6, 8];
        $per_page = in_array($per_page, $per_page_values) ? $per_page : 6;

        $sort_by_values = ['price-asc', 'price-desc'];
        $sort_by = in_array($sort_by, $sort_by_values) ? $sort_by :$sort_by_values[0];
        $sort_by_array = explode('-', $sort_by);

        $key =  $sort_by_array[0];
        $value = $sort_by_array[1];

        $query = Product::orderBy($key, $value);
        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $products = $query->paginate($per_page)->appends([
            'sort_by' => $sort_by,
            'per_page' => $per_page,
            'search' => $search
        ]);
        $favourites = Auth::user()->favourites->pluck('id')->toArray();



        // handling filter part
        $specs = ProductSpec::all();
        $filters = [];
        foreach ($specs as $spec) {
            $name = $spec->name;
            $value = $spec->value;
        
            if (!isset($filters[$name])) {
                $filters[$name] = [];
            }
        
            if (!in_array($value, $filters[$name])) {
                $filters[$name][] = $value;
            }
        }

        return view('home.index', compact(
            'products', 
            'favourites', 
            'search', 
            'sort_by', 
            'per_page', 
            'per_page_values',
            'filters'
        ));
    }

}

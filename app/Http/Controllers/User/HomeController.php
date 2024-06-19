<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }


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

        [$filters, $applied_filters] = $this->productService->getAllFilters($request->all());
        $per_page = $this->productService->getPerPage($per_page);
        $query = $this->productService->getProducts($sort_by, $applied_filters);

        $products = $query->paginate($per_page)->appends([
            'sort_by' => $sort_by,
            'per_page' => $per_page,
            'search' => $search,
            
        ] + $this->productService->serializeFilters($applied_filters));

        $favourites = Auth::user()->favourites->pluck('id')->toArray();

        return view('home.index', compact(
            'products', 
            'favourites', 
            'search', 
            'sort_by', 
            'per_page',
            'filters',
            'applied_filters'
        ) + [
            'per_page_values' => $this->productService->PER_PAGE_VALUES,
            // 'sort_by_values' => $this->SORT_BY_VALUES
        ]);
    }


    public function favourites(Request $request) {

        $sort_by = $request->input('sort_by', 'price-asc');
        $per_page = (int) $request->input('per_page', 6);
        $per_page = $this->productService->getPerPage($per_page);

        [$order_key, $order_value] =  $this->productService->getOrderBy($sort_by);

        $query =  Auth::user()->favourites()->orderBy($order_key, $order_value);
    
        $products = $query->paginate($per_page)->appends([
            'sort_by' => $sort_by,
            'per_page' => $per_page
        ]);

        return view('home.favourites.index', compact(
            'products',
            'sort_by', 
            'per_page', 
        ) + [
            'per_page_values' => $this->productService->PER_PAGE_VALUES,
            // 'sort_by_values' => $this->SORT_BY_VALUES
        ]);
    }



    public function cart() {
        $cart = Auth::user()->shoppingCart()->with('product')->get();
        return view('home.cart.index', compact('cart'));
    }


}

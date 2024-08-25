<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Http\Request;
use App\Utils\Utils;

class HomeController extends Controller
{

    private function getAllSpecs()
    {
        $productSpecs = ProductSpec::getAllSpecsGroupedByName();

        $productSpecs['category'] = Category::orderBy('name')->get()->pluck('name')->toArray();

        // sort all the specs by key
        ksort($productSpecs);

        return $productSpecs;
    }




    public function index(Request $request)
    {

        $products = Product::with('category')->paginate(5);
        $customer = $request->customer;

        $productSpecs = $this->getAllSpecs();

        $favourites = $customer ? $customer->favourites()->pluck('id')->toArray() : [];
        $nrOfCartProducts = $customer ? $customer->getNumberOfCartProducts() : 0;
        $cart = $customer ? $customer->shoppingCart()->pluck('quantity', 'product_id')->toArray() : [];

        return view(
            'customer.home.index',
            compact(
                'products',
                'favourites',
                'nrOfCartProducts',
                'productSpecs',
                'cart'
            )
        );
    }


    public function applyFilter(Request $request)
    {

        $queryParams = Utils::getAllQueryParams($request->all());

        $specs = $this->getAllSpecs();
        $appliedFilters = array_intersect_key($queryParams, $specs);

        $sortBy = $queryParams['sortBy'] ?? 'default';

        $products = Product::filter($appliedFilters)->sortBy($sortBy)
            ->with('category')
            ->paginate(100)
            ->appends($appliedFilters);
        $customer = $request->customer;

        $favourites = $customer ? $customer->favourites()->pluck('id')->toArray() : [];
        return response()->json([
            'status' => 'success',
            'message' => 'Filter applied!',
            'data' => [
                'queryString' => http_build_query($queryParams),
                'nrProducts' => $products->count(),
                'html' => view('customer.home.products', compact('products', 'favourites'))->render()
            ]
        ]);
    }


    // 
    // public function index(Request $request) {
    // {
    //     $sort_by = $request->input('sort_by', 'cce-asc');
    //     $per_page = (int) $request->input('per_page', 6);
    //     $search = $request->input('search', '');
    //     $categories = $request->input('cateogory', '');

    //     [$filters, $applied_filters] = $this->productService->getAllFilters($request->all());
    //     $per_page = $this->productService->getPerPage($per_page);
    //     $query = $this->productService->getProducts($sort_by, $applied_filters);

    //     $products = $query->paginate($per_page)->appends([
    //         'sort_by' => $sort_by,
    //         'per_page' => $per_page,
    //         'search' => $search,
    //         'categories' => $categories

    //     ] + $this->productService->serializeFilters($applied_filters));

    //     $favourites = [];
    //     if (Auth::check()) {
    //         $favourites = Auth::user()->favourites->pluck('id')->toArray();
    //     }



    //     return view('home.index', compact(
    //         'products',
    //         'favourites',
    //         'search',
    //         'sort_by',
    //         'per_page',
    //         'filters',
    //         'applied_filters',
    //     ) + [
    //         'per_page_values' => $this->productService->PER_PAGE_VALUES,
    //         // 'sort_by_values' => $this->SORT_BY_VALUES
    //     ]);
    // }



}

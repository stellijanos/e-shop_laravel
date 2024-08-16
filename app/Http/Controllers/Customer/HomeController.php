<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


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

    private function getNewQueryString($req)
    {

        $key = $req['specName'];
        $value = $req['specValue'];
        $apply = $req['apply'];
        $queryString = $req['queryString'];

        parse_str($queryString, $queryParams);

        if ($apply === "true") {

            if (!isset($queryParams[$key])) {
                $queryParams[$key] = [];
            }

            if (!is_array($queryParams[$key])) {
                $queryParams[$key] = [$queryParams[$key]];
            }

            if (!in_array($value, $queryParams[$key])) {
                $queryParams[$key][] = $value;
            }
        } else {

            if (!isset($queryParams[$key]))
                return;

            if (!is_array($queryParams[$key])) {
                if ($queryParams[$key] === $value) {
                    unset($queryParams[$key]);
                }
                return;
            }
            $queryParams[$key] = array_values(array_filter($queryParams[$key], function ($v) use ($value) {
                return $v !== $value;
            }));

            if (empty($queryParams[$key])) {
                unset($queryParams[$key]);
            }
        }

        return $queryParams;
    }


    public function applyFilter(Request $request)
    {

        $appliedFilters = $this->getNewQueryString($request->all());

        $specs = $this->getAllSpecs();
        $appliedFilters = array_intersect_key($appliedFilters, $specs);

        $products = Product::filter($appliedFilters)
            ->with('category')
            ->paginate(100)
            ->appends($appliedFilters);
        $customer = $request->customer;

        $favourites = $customer ? $customer->favourites()->pluck('id')->toArray() : [];
        return response()->json([
            'status' => 'success',
            'message' => 'Filter applied!',
            'data' => [
                'queryString' => http_build_query($appliedFilters),
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

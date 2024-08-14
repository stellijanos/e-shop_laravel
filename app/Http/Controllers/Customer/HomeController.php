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


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        // get all the filters from the request
        $appliedFilters = $request->all();

        // get all the product specs grouped by name
        $productSpecs = ProductSpec::getAllSpecsGroupedByName();

        // add the name of all categories ordered by name as spec
        $productSpecs['category'] = Category::orderBy('name')->get()->pluck('name')->toArray();

        // sort all the specs by key
        ksort($productSpecs);

        // get the applied filters that also exist
        $appliedFilters = array_intersect_key($appliedFilters, $productSpecs);

        // get filtered category names
        $category_filter = $appliedFilters['category'] ?? [];

        // unset it from the applied filters to be able to query in product_spec table
        unset($appliedFilters['category']);

        // get the checked categories as collection
        $checked_categories = Category::whereIn('name', $category_filter)->get();

        // create array from the id's of those categories
        $checked_category_ids = $checked_categories->pluck('id')->toArray();

        // create array from the name of those categories
        $checked_category_names = $checked_categories->pluck('name')->toArray();

        // get the product applied with selected categories and filters
        $products = Product::categories($checked_category_ids)->filter($appliedFilters)->paginate(5);


        $favourites = [];
        $nrOfCartProducts = 0;
        $cart = [];
        if (Auth::check()) {

            $customer = Customer::getCustomer(Auth::user()->id);

            $favourites = $customer ? $customer->favourites()->pluck('id')->toArray() : [];

            // get favourite product id's

            $nrOfCartProducts = $customer ? $customer->getNumberOfCartProducts() : 0;

            $cart = $customer ? $customer->shoppingCart()->pluck('quantity', 'product_id')->toArray() : [];
        }

        // set category filter back to applied filters in order to be visible on the frontend which filter was applied
        $appliedFilters['category'] = $category_filter;


        return view(
            'customer.home.index',
            compact(
                'products',
                'favourites',
                'productSpecs',
                'checked_category_names',
                'appliedFilters',
                'nrOfCartProducts',
                'cart'
            )
        );
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

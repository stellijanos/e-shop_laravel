<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

        // print_r($request->all());


        $appliedFilters = $request->all();

        // get all the product specs grouped by name
        $productSpecs = ProductSpec::getAllSpecsGroupedByName();

        // add the name of all categories ordered by name as spec
        $productSpecs['category'] = Category::orderBy('name')->get()->pluck('name')->toArray();

        // sort all the specs by key
        ksort($productSpecs);

        // print_r($productSpecs);

        // get the applied filters that also exist
        $appliedFilters = array_intersect_key($appliedFilters, $productSpecs);


        // print_r($appliedFilters);
        echo 'FILTERS:=> ';
        print_r($appliedFilters);

        $category_filter = $appliedFilters['category'] ?? [];
        unset($appliedFilters['category']);
        $checked_categories = Category::whereIn('name', $category_filter)->get();

        $checked_category_ids = $checked_categories->pluck('id')->toArray();
        $checked_category_names = $checked_categories->pluck('name')->toArray();



        $products = Product::categories($checked_category_ids)->filter($appliedFilters)->paginate(5);

        $favourites = Auth::check() ? Auth::user()->favourites->pluck('id')->toArray() : [];

        $appliedFilters['category'] = $category_filter;


        echo "checked category names=>";
        print_r($checked_category_names);

        return view(
            'home.index-new',
            compact(
                'products',
                'favourites',
                'productSpecs',
                'checked_category_names',
                'appliedFilters'
            )
        );
    }



    // 
    // public function index(Request $request) {
    // {
    //     $sort_by = $request->input('sort_by', 'price-asc');
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


    public function favourites(Request $request)
    {

        $sort_by = $request->input('sort_by', 'price-asc');
        $per_page = (int) $request->input('per_page', 6);
        $per_page = $this->productService->getPerPage($per_page);

        [$order_key, $order_value] = $this->productService->getOrderBy($sort_by);

        $query = Auth::user()->favourites()->orderBy($order_key, $order_value);

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



    public function cart()
    {
        $cart = Auth::user()->shoppingCart()->with('product')->get();
        return view('home.cart.index', compact('cart'));
    }

}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Utils\Response;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{


    public function show(Request $request)
    {

        $customer = $request->customer;

        $products = $customer->favourites()->get();

        $favourites = $customer->favourites()->pluck('id')->toArray();

        $nrOfCartProducts = $customer->getNumberOfCartProducts();

        return view('customer.favourites.index', compact('products', 'favourites', 'nrOfCartProducts'));

        // $sort_by = $request->input('sort_by', 'price-asc');
        // $per_page = (int) $request->input('per_page', 6);
        // $per_page = $this->productService->getPerPage($per_page);

        // [$order_key, $order_value] = $this->productService->getOrderBy($sort_by);

        // $customer = Customer::getCustomer(Auth::user()->id);

        // $query = $customer->favourites()->orderBy($order_key, $order_value);

        // $products = $query->paginate($per_page)->appends([
        //     'sort_by' => $sort_by,
        //     'per_page' => $per_page
        // ]);

        // return view('home.favourites.index', compact(
        //     'products',
        //     'sort_by',
        //     'per_page',
        // ) + [
        // 'per_page_values' => $this->productService->PER_PAGE_VALUES,
        // 'sort_by_values' => $this->SORT_BY_VALUES
        // ]);
    }

    public function toggleFavourite(Request $request, Product $product)
    {
        $customer = $request->customer;

        $status = $customer->toggleFavourite($product);
        $message = $status === "added" ? "Product added to favourites!" : "Product removed from favourites!";

        return (new Response($status, $message))->get();
    }


    public function removeFromFavourites(Request $request, Product $product)
    {
        $customer = $request->customer;

        $status = $customer->removeFromFavourites($product);

        $products = $customer->favourites()->with('category')->get();

        $favourites = $customer->favourites()->pluck('id')->toArray();

        $message = $status === "removed" ? "Product removed from favourites!" : "Something went wrong!";
        $html = $status === "removed" ? view('customer.home.products', compact('products'))->render() : '';
        $data = compact('html', 'favourites');

        return (new Response($status, $message, 200, $data))->get();
    }
}

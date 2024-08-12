<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Request $request, Product $product)
    {

        $product = $product->load('reviews.customer');
        $isFavourite = false;
        $wasReviewed = false;

        $currentCustomer = $request->customer;

        dd($product->reviews->customer);

        if ($currentCustomer) {
            $favourite_products_ids = $currentCustomer->favourites()->pluck('id')->toArray();
            $isFavourite = in_array($product->id, $favourite_products_ids);
            $wasReviewed = $product->wasReviewedBy($currentCustomer->id);
        }

        return view('product.show', compact('product', 'isFavourite', 'wasReviewed'));
    }
}

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

        $favourites = [];

        $currentCustomer = $request->customer;
        $nrOfCartProducts = 0;

        if ($currentCustomer) {
            $favourites = $currentCustomer->favourites()->pluck('id')->toArray();
            $isFavourite = in_array($product->id, $favourites);
            $wasReviewed = $product->wasReviewedBy($currentCustomer->id);
            $nrOfCartProducts = $currentCustomer->getNumberOfCartProducts();
        }

        return view('product.show', compact('product', 'isFavourite', 'wasReviewed', 'favourites', 'nrOfCartProducts'));
    }
}

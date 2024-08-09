<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!$product) {
            abort(404);
        }
        $product = $product->load('reviews.customer');
        $isFavourite = false;
        $wasReviewed = false;

        $customer = Customer::getCustomer(Auth::user()->id);

        if ($customer) {
            $favourite_products_ids = $customer->favourites()->pluck('id')->toArray();
            $isFavourite = in_array($product->id, $favourite_products_ids);
            $wasReviewed = $product->wasReviewedBy($customer->id);
        }

        return view('product.show', compact('product', 'isFavourite', 'wasReviewed'));
    }
}

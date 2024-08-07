<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
        $product = $product->load('reviews.user');
        $isFavourite = false;
        $wasReviewed = false;

        if (Auth::check()) {
            $favourite_products_ids = Auth::user()->favourites()->pluck('id')->toArray();
            $isFavourite = in_array($product->id, $favourite_products_ids);
            $wasReviewed = $product->wasReviewedBy(Auth::user()->id);
        }
        return view('product.show', compact('product', 'isFavourite', 'wasReviewed'));
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    public function toggleFavourite(Request $request, Product $product)
    {

        $customer = $request->customer;

        $status = $customer->toggleFavourite($product);
        $message = $status === "added" ? "Product added to favourites!" : "Product removed from favourites!";

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);

    }
}

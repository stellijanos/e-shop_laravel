<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Product $product)
    {

        if (!$product)
            abort(404, 'Product not found!');

        $wasReviewed = $product->wasReviewedBy(Auth::user()->id);

        // dd($wasReviewed);

        if ($wasReviewed)
            return redirect()->route('product', ['product' => $product->id]);

        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'description' => 'max:1000'
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::user()->id,
            'rating' => $request->rating,
            'description' => $request->description ?? ''
        ]);

        return redirect()->route('product.show', ['product' => $product->id]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

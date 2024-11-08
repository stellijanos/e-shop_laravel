<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        $wasReviewed = $product->wasReviewedBy(Auth::user()->id);

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
     * @param  Product $prodcuct
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, User $user)
    {

        $review = Review::getByUserAndProduct($user, $product);

        if (!$review) {
            return response()->json([
                'message' => 'Review not found.',
            ], 404);
        }

        $wasReviewed = $product->wasReviewedBy(Auth::user()->id);

        if (!$wasReviewed) {
            return response()->json([
                'message' => 'You do not have a review for this product.',
            ], 422);
        }

        $rules = [
            'rating' => 'required|numeric|min:1|max:5',
            'description' => 'sometimes|max:1000'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->toArray()
            ], 422);

        }

        $data = [
            'rating' => $request->rating,
            'description' => $request->description
        ];

        $review = Review::updateReview($user, $product, $data);

        return response()->json([
            'message' => 'Successfully updated',
            'data' => [
                'review' => $review
            ]
        ]);
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

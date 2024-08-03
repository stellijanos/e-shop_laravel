@extends('layouts.app')
@section('content')
@include('product.css')

<style>
    #product {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 2rem;
    }
</style>
@php
    $favouriteIcon = $isFavourite ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>' : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
@endphp
<div class="container" id="product">
    <img class="rounded img-fluid" src="{{asset('images/products/' . $product->image)}}" alt="{{$product->name}}-image"
        style="max-width:500px">
    <div class="card" style="width:500px">
        <div class="card-body" style="padding-left:30px;">
            <p class="fs-1 fw-bold m-0">{{$product->name}}</p>
            <p class="fs-1 text-start fw-bold m-2">${{$product->price}}</p>
            <hr>
            <div class="d-flex flex-row gap-3" style="color:#000;">
                <button class="btn btn-white" data-product-id="{{$product->id}}" onclick="favourite(this)">
                    <?=$favouriteIcon?>
                </button>
                <button class="btn btn-white" data-product-id="{{$product->id}}" onclick="addToCart(this)">
                    <i class="fa-solid fa-cart-plus fa-2x"></i>
                </button>
            </div>
            <hr>
            <span class="fw-bold fs-3">Category: {{$product->category->name}}</span>
            <hr>
            <span class="fw-bold fs-3">Description:</span>
            <p class="m-1">{{$product->description}}</p>
        </div>
    </div>
    <div class="card" style="width:100%">
        <p class="fs-2 fw-bold m-0 px-5">Reviews ({{$product->reviews->count()}})</p>
        <hr>

        @auth
            <p class="fs-3 fw-bold m-0 px-5">Add a review</p>
            <form action="">
                <div class="d-flex flex-direction-row w-100">
                    <div class="mb-3 w-75">

                        <textarea name="description" class="form-control w-100" style="height:200px"
                            id="description">Description</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="rating">Choose rating (between 1-5)</label>
                        <select class="form-select w-10" id="rating" name=rating>
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <button type="submit" class="btn btn-success mb-3 w-100">Add review</button>
                    </div>
                </div>
            </form>
        @endauth
        @foreach($product->reviews as $review)        
            <hr>
            {{$review->name}}
        @endforeach
    </div>
</div>

@auth
    @include('product.js-handling')
@endauth
@endsection

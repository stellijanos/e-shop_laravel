@extends('layouts.app')
@section('content')
@include('product.css')

<style>
    .card-body--main-info {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .card-body__details {
        padding-top: 20px;
        font-size: 1.5rem;
        padding: 30px;
        margin-left: 0
    }

    .card-body__details {
        position: relative;
    }
</style>
@php
    $favouriteIcon = $isFavourite ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>' : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
@endphp

<div class="container">
    <div class="card w-100">
        <div class="card-body card-body--main-info">
            <img src="{{asset('images/products/' . $product->image)}}" class="{{$product->name}}-image"
                style="width:80%; max-width:500px;">
            <div class="card-body__details">
                @include('visual-effects.spinner')
                <h5 class="card-title fw-bold fs-1">{{$product->name}}</h5>
                <p class="card-text">${{$product->price}}</p>
                <p class="card-text">({{$product->stock}} left in stock)</p>
                <p class="card-text">Category: {{$product->category->name}}</p>
                <hr>
                <div class="d-flex flex-row gap-3" style="color:#000;">
                    <button class="btn btn-white toggle-favourites" data-product-id="{{$product->id}}">
                        <?=$favouriteIcon?>
                    </button>
                    <button class="btn btn-white inc-cart-item" data-product-id="{{$product->id}}">
                        <i class="fa-solid fa-cart-plus fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            <span class="fw-bold fs-3">Description:</span>
            <p class="m-1">{{$product->description}}</p>
            <hr>
        </div>
        <hr>
        <div class="card-body">
            <h5 class="card-title">Reviews ({{$product->reviews->count()}})</h5>
            @if(!$wasReviewed)
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-review-modal">
                    Add a review
                </button>
                @include('product._add-review-modal')
            @endif
        </div>

        <div class="card-body">
            @forelse($product->reviews as $review)   
                <hr>
                <p>{{$review->customer->firstname}} {{$review->customer->lastname}} on
                    {{(new DateTime($review->created_at))->format('Y.m.d')}}
                </p>
                Rating: {{$review->rating}}
                Description: {{$review->description}}
            @empty
                <p>No reviews were found.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
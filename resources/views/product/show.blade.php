@extends('layouts.app')
@section('content')
@include('product.css')

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
                    <button class="btn btn-white add-to-cart" data-product-id="{{$product->id}}">
                        <i class="fa-solid fa-cart-plus fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body">
            <span class="fw-bold fs-3">Description:</span>
            <p class="m-1">{{$product->description}}</p>
        </div>
        <hr>
        <div class="card-body">
            <h5 class="card-title">Reviews ({{$product->reviews->count()}})</h5>
            @auth
                @if(Auth::user()->role !== 'admin' && !$wasReviewed)
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#add-review-modal">
                        Add a review
                    </button>
                    @include('product._add-review-modal')
                @endif
            @endauth

            @forelse($product->reviews as $review)   
                <div class="d-flex flew-row justify-content-between">
                    <div>

                        <hr>

                        <p class="mb-0"><b>{{$review->customer->firstname}} {{$review->customer->lastname}}</b> on
                            {{(new DateTime($review->created_at))->format('Y.m.d')}}
                        </p>
                        <div class="user-rating">
                            @for ($i = 1; $i <= $review->rating; $i++)
                                <span class="checked">&#9733;</span>
                            @endfor
                            @for ($j = $i; $j <= 5; $j++)
                                <span>&#9733;</span>
                            @endfor
                        </div>
                        @if ($review->description)
                            "{{$review->description}}"
                        @endif
                    </div>
                    @if($wasReviewed)
                        <div>
                            <form action="" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p>No reviews were found.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
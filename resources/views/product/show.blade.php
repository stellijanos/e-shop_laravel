@extends('layouts.app')
@section('content')
@include('product.css')

<style>
    #product {
        display:flex;
        flex-direction:row;
        flex-wrap:wrap;
        gap:2rem;
    }
</style>
@php
    $favouriteIcon = $isFavourite ? '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>' : '<i class="fa-regular fa-heart fa-2x" ></i>'; 
@endphp
<div class="container" id="product">
    <img class="rounded img-fluid" src="{{asset('images/products/'.$product->image)}}" alt="{{$product->name}}-image" style="max-width:500px">
    <div class="card" style="width:500px">
        <div class="card-body" style="padding-left:30px;">
            <p class="fs-1 fw-bold m-0">{{$product->name}}</p>
            <p class="fs-1 text-start fw-bold m-2">${{$product->price}}</p>
            <hr>
            <div class="d-flex flex-row gap-3" style="color:#000;">
                <button class="btn btn-white" data-product-id="{{$product->id}}" onclick="favourite(this)">
                    <?=$favouriteIcon?>
                </button>
                <button class="btn btn-white" data-product-id="{{$product->id}}"onclick="addToCart(this)">
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
</div>

@auth
    @include('product.js-handling')
@endauth
@endsection

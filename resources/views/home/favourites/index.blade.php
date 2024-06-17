@extends('layouts.app')
@section('content')
@include('product.css')

<div class="container align-self-start">
    @if($products->count() === 0 )
        @include('home.no-products')
    @else   
        @include('home.favourites.products')
    @endif
</div>

@include('product.js-handling')
@endsection

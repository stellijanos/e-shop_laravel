@extends('layouts.app')
@section('content')
<style>
    i {
        cursor:pointer;
    }
    i:active {
        transform: scale(1.2);
    }

    input[type="checkbox"], input[type="checkbox"]:hover + label {
        cursor: pointer;
        user-select: none;
    }

    div.product-item:hover, div.product-item:active {
            transform:scale(1.03);
            cursor:pointer;
    }

</style>

<div class="container align-self-start">
    @if($products->count() === 0 )
        @include('home.no-products')
    @else   
        @include('home.favourites.products')
    @endif
</div>

@include('home.product-handling')
@endsection

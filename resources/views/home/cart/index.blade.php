@extends('layouts.app')
@section('content')


<style>
    #cart {
        display:flex;
        flex-direction: row;
        flex-wrap:wrap-reverse;
        justify-content: space-around;
        gap:1rem;
    }


    div.card > img {
        width:150px;
        height:150px;
    }

    #items {
        display:flex;
        flex-direction: column;
        gap:1rem;
    }

    .summary-info {
        display:flex;
        flex-direction: row;
        justify-content:space-between;
    }

</style>

<div id="cart">
    @if($cart->count() === 0 )
        @include('home.no-products')
    @else   
        @include('home.cart.products')
    @endif
</div>
@endsection

@extends('layouts.app')
@section('content')


<div class="container" id="main-container">
    @if(count($cart) === 0)
        @include('customer.home.no-products')
    @else
        @include('customer.cart.product-list')
    @endif
</div>
@endsection
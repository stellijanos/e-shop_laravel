@extends('layouts.app')
@section('content')


<div class="container">
    @empty($cart)
        @include('home.no-products')
    @else
        @include('customer.cart.product-list')
    @endempty
</div>
@endsection
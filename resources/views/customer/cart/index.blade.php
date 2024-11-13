@extends('layouts.app')
@section('content')
<div id="app-page" data-page="cart">
    <div class="container mb-5" id="cart-list">
        @include('customer.cart.products')
    </div>
</div>
@endsection
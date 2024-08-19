@extends('layouts.app')
@section('content')
<div class="container mb-5" id="cart-list">
    @include('customer.cart.products')
</div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container" id="cart-list">
    @include('customer.cart.products')
</div>
@endsection
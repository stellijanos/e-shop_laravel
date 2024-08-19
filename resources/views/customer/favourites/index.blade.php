@extends('layouts.app')
@section('content')
@include('product.css')
<div class="container">
    <div class="d-flex flex-row justify-content-start flex-wrap gap-5 mb-5" id="product-list">
        @include('customer.home.products')
    </div>
</div>
@endsection
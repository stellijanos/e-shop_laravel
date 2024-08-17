@extends('layouts.app')
@section('content')
@include('product.css')
<div class="container">
    <form class="row mb-3">

    </form>
    <div class="d-flex flex-row justify-content-start flex-wrap gap-5 mb-5" id="product-list">
        @include('customer.home.products')
    </div>
</div>
<!-- <div id="no-products" class="text-center"
        style="width:100%; height:200px; display:flex; justify-content:center; align-items:center">
        <p class="fs-1 fw-bold">No products were found.</p>
    </div> -->
@endsection
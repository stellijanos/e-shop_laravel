@extends('layouts.app')
@section('content')
@include('customer.includes.filter-modal')
<?php
$sortBy = [
    ['default', 'Default'],
    ['price-asc', 'Price (Ascending)'],
    ['price-desc', 'Price (Descending)'],
    ['name-asc', 'Name (Ascending)'],
    ['name-desc', 'Name (Descending)'],
]

?>
<div class="container d-flex flex-column">
    <div class="header-options d-flex flex-row mb-3 w-100 gap-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter-modal">
            Filters <span>(0)</span>
        </button>
        <select name="sort_by" id="sort-by" class="form-select" style="width:200px">
            @foreach ($sortBy as $option)
                <option value="{{$option[0]}}">{{$option[1]}}</option>
            @endforeach
        </select>
    </div>
    <div class="container" id="product-list">
        @include('customer.home.products')
    </div>
</div>

@endsection
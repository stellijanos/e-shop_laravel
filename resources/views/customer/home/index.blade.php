@extends('layouts.app')
@section('content')
@include('customer.includes.filter-modal')

<div class="container d-flex flex-column">
    <div class="header-options d-flex flex-row mb-3 w-100 gap-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter-modal">
            Filters <span>(0)</span>
        </button>
        <select name="sort_by" id="sort-by" class="form-select" style="width:200px">
            <option value="_">Default</option>
            <option value="price-asc">Price (Ascending)</option>
            <option value="price-desc">Price (Descending)</option>
        </select>
    </div>
    <div class="container" id="product-list">
        @include('customer.home.products')
    </div>
</div>

@endsection
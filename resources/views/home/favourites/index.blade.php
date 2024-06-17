@extends('layouts.app')
@section('content')
<style>
    i {
        cursor:pointer;
    }
    i:active {
        transform: scale(1.2);
    }

    input[type="checkbox"], input[type="checkbox"]:hover + label {
        cursor: pointer;
        user-select: none;
    }

    div.product-item:hover, div.product-item:active {
            transform:scale(1.03);
            cursor:pointer;
    }

</style>

<div class="container align-self-start">

    @if($products->count() === 0 )
        @include('home.no-products')
    @else   
        <form class="row mb-3">
            <div class="col-3">
                <div class=" input-group">
                    <label class="input-group-text" for="sort-by">Sort by: </label>
                    <select name="sort_by" id="sort-by" class="form-select" onchange="this.form.submit()">
                        <option value="_">Default</option>
                        <option value="price-asc" {{$sort_by=== "price-asc" ? 'selected' : ''}}>Price (Ascending)</option>
                        <option value="price-desc" {{$sort_by === "price-desc" ? 'selected' : ''}}>Price (Descending)</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class=" input-group" style="width:200px;">
                    <label class="input-group-text" for="show-per-page">Show per page: </label>
                    <select class="form-select" name="per_page" id="show-per-page" onchange="this.form.submit()">
                        @foreach ($per_page_values as $page_value)
                            <option value="{{$page_value}}" {{$per_page === $page_value ? 'selected' : ''}}>{{$page_value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <div class="d-flex flex-row justify-content-start flex-wrap gap-5 mb-5" id="product-list">
            @include('home.favourites.products')
        </div>
        <div class="text-center">
                {{$products->links()}}
        </div>    

    @endif
</div>


@include('home.product-handling')
@endsection

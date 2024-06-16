@extends('layouts.app')
@section('content')
<style>
    i {
        cursor:pointer;
    }
    i:active {
        transform: scale(1.2);
    }

    input[type="checkbox"] + label {
        cursor:pointer;
        user-select: none;
    }

</style>
<div class="d-flex flex-direction-row">
    <div class="col-2 shadow rounded" style="padding:0 30px 30px; width:200px; margin-right:30px" id="filters">
        <p class="fs-2 text-center fw-bold mb-0 pb-0">Filters</p>
        
        @foreach ($filters as $filter => $values)
            {{$filter}}
            @foreach($values as $name) 
                <div class="input-group">
                    <input type="checkbox" class="mx-2" name="{{$filter}}" id="{{$name}}" value="{{$name}}">
                    <label for="{{$name}}">{{$name}}</label>
                </div>
            @endforeach
        @endforeach
    </div>
    <div class="col-10 row" id="product-list">
        @include('home.products')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

    function favourite(button) {

        const productId = button.getAttribute('data-product-id');

        axios.post(`{{url('/account/favourite')}}/${productId}`)
        .then(response => {
            let responseText = response.data.response;
            if (responseText === "added") {
                button.innerHTML = '<i class="fa-solid fa-heart fa-2x" style="color:red;"></i>';
            } else if (responseText === "removed") {
                button.innerHTML = '<i class="fa-regular fa-heart fa-2x" ></i>'
            }
        })
        .catch(error => {
            //
        });
    }

    function addToCart(button) {
        const productId = button.getAttribute('data-product-id');
        button.innerHTML = '<i class="fa-solid fa-check fa-2x"></i>';

        axios.post(`{{url('/account/add-to-cart')}}/${productId}`)
        .then(response => {
            let responseText = response.data.response;
            if(responseText === "added") {
                button.innerHTML = '<i class="fa-solid fa-cart-plus fa-2x"></i>';
            }
        })
        .catch(error => {});

    }

    function sortProducts(submit) {
        const orderBy = submit.value;

        const productList = document.getElementById('product-list');

        axios.post(`{{url('/sort')}}/${orderBy}`)
        .then(response => {
            productList.innerHTML = response.data;
            
        })
        .catch(error => {}
        );
    }


    function showPerPage(submit) {
        const perPage = submit.value;

        productList = document.getElementById('product-list');

        axios.post(`{{url('/per-page')}}/${perPage}`)
        .then(response => {
            productList.innerHTML = response.data;
        })
        .catch(error => {
        });
    }

</script>
@endsection

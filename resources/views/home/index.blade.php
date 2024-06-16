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


</style>
<form class="d-flex flex-direction-row" action="{{route('home')}}" method="get">
    <div class="col-2 accordion" style="padding:0 30px 0 10px; width:250px; " id="accordionPanelsStayOpenExample" id="filters">
        @foreach ($filters as $filter => $values)
            @php 

                $index_1 = $loop->index;
            @endphp
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$loop->index}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$loop->index}}">
                        {{ucfirst($filter)}}
                    </button>
                </h2>
                <div id="paneivtayOpen-collapse-{{$loop->index}}" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        @foreach($values as $value => $checked) 
                            <div>
                                <input type="checkbox" class="mx-2 form-check-input" name="{{$filter}}[]" id="{{$value}}-{{$index_1}}-{{$loop->index}}" value="{{$value}}" {{$checked}} onchange="this.form.submit()">
                                <label for="{{$value}}-{{$index_1}}-{{$loop->index}}">{{$value}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-10 row align-self-start" id="product-list">
        @include('home.products')
    </div>
</form>
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

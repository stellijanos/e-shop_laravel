@extends('layouts.app')
@section('content')
@include('product.css')

@if($products->count() !== 0)
    <form class="d-flex flex-direction-row" action="{{route('home')}}" method="get">
        <div class="col-2 accordion" style="padding:0 30px 0 10px; width:250px; " id="accordionPanelsStayOpenExample" id="filters">
            @foreach ($filters as $filter => $values)
                @php 
                    $index_1 = $loop->index;
                @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-{{$index_1}}" aria-expanded="true" aria-controls="panelsStayOpen-collapse-{{$index_1}}">
                            {{ucfirst($filter)}}
                        </button>
                    </h2>
                    <div id="panelsStayOpen-collapse-{{$index_1}}" class="accordion-collapse collapse show">
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
@else
    @include('home.no-products')
@endif 

@auth
    @include('product.js-handling')
@endauth
@endsection

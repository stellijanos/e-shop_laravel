@extends('layouts.app')
@section('content')
@include('product.css')


<form class="d-flex flex-direction-row" action="{{route('home')}}" method="get">
    <div class="col-2 accordion" style="padding:0 30px 0 10px; width:250px; " id="accordionPanelStayOpenExample"
        id="filters">
        @foreach ($productSpecs as $specName => $values)
            @php 
                $index_1 = $loop->index;
            @endphp
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#panelStayOpen-collapse-{{$index_1}}" aria-expanded="true"
                        aria-controls="panelStayOpen-collapse-{{$index_1}}">
                        {{ucfirst($specName)}}
                    </button>
                </h2>
                <div id="panelStayOpen-collapse-{{$index_1}}" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        @foreach($values as $key => $spec) 
                            <div>
                                <input type="checkbox" class="mx-2 form-check-input" name="{{$specName}}[]"
                                    id="{{$spec}}-{{$index_1}}-{{$loop->index}}" value="{{$spec}}" {{ isset($appliedFilters[$specName]) ? in_array($spec, $appliedFilters[$specName]) ? 'checked' : '' : ''}} onchange="this.form.submit()">
                                <label for="{{$spec}}-{{$index_1}}-{{$loop->index}}">{{$spec}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-10 row align-self-start" id="product-list">
        

        @if($products->count() === 0)
            @include('customer.home.no-products')
        @else
            @include('customer.home.products')
        @endif 

    </div>
</form>

@endsection
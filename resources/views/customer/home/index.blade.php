@extends('layouts.app')
@section('content')


<div class="container d-flex flex-direction-row">

    <form class="d-flex flex-direction-row" action="{{route('home')}}" method="get">
        <div class="col-2 accordion" style="padding:0 30px 0 10px; width:250px; " id="filters">
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
                                    <input type="checkbox" class="mx-2 form-check-input filter" name="{{$specName}}"
                                        id="{{$spec}}-{{$index_1}}-{{$loop->index}}" value="{{$spec}}">
                                    <label for="{{$spec}}-{{$index_1}}-{{$loop->index}}">{{$spec}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </form>

    <div class="container" id="product-list">
        @include('customer.home.products')
    </div>
</div>

@endsection

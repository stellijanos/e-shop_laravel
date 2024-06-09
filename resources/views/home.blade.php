@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-flex-start">
        @foreach ($products as $product )
            <div class="bg-body-secondary text-light-emphasis rounded text-center shadow pt-3" style="width:150px">
                <img class="rounded" src="{{asset('public/images/products/'.$product->image)}}" style="width:120px; height:120px" alt="{{$product->name}}-image">
                <figcaption>
                    <p class="text-truncate fs-3 fw-bold m-0" style="max-width: 150px;">{{$product->name}}</p>
                    <p class="text-truncate fw-bold m-0" style="max-width: 150px;">({{$product->category->name}})</p>
                    <p class="text-truncate m-1" style="max-width: 150px;">{{$product->description}}</p>
                    <p class="fs-5 text-start fw-bold m-0">${{$product->price}}</p>
                    <div class="row justify-content-around mb-1">
                        <button class="btn btn-white col-4"><i class="fa-solid fa-heart fa-2x" style="color:red; height:"></i></button>
                        <button class="btn btn-white col-4"><i class="fa-solid fa-cart-plus fa-2x"></i></button>
                    </div>
                </figcaption>
            </div>
        @endforeach

        <div class="text-center">
            {{$products->links()}}
        </div>
    </div>
</div>
@endsection

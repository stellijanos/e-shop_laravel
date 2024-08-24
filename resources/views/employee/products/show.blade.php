@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Details', 'group' => 'products'])
    </div>
    <div class="card-body">
        <div class="details mx-3 mb-3 row">

            <div class="image col-lg-6 mx-3" style="width:300px">
                <img src="{{asset('images/products')}}/{{$product->image}}" alt="{{$product->name}}-image"
                    style="width:300px">
            </div>
            <div class="col-lg-6 mt-3">
                <p>Product #{{$product->id}}</p>
                <p>Name: {{$product->name}}</p>
                <p>Catetory: {{$product->category->name}}</p>
                <p>Price: ${{$product->price}}</p>
                <p>Description: "{{$product->description}}"</p>
                <p>Stock: {{$product->stock}}</p>
                <p>Specs: ({{$product->specs->count()}})</p>
                <ul>
                    @foreach ($product->specs as $spec)
                        <li>{{$spec->name}}: {{$spec->value}}</li>
                    @endforeach
                </ul>

                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{route('products.edit', $product->id)}}" class="btn btn-warning w-100">Edit</a>
                    </div>
                    <form action="{{route('products.destroy', $product->id)}}" method="post" class="col-sm-6">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
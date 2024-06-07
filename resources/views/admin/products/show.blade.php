
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-dark" href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('admin/product')}}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger w-50" role="alert">
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="details mx-3 mb-3 row">
                        
                        <div class="image col-lg-6 mx-3" style="width:300px"> 
                            <img src="{{asset('public/images/products')}}/{{$product->image}}" alt="{{$product->name}}-image" style="width:300px">
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
                                @foreach ($product->specs as $spec )
                                    <li>{{$spec->name}}: {{$spec->value}}</li>
                                @endforeach
                            </ul>

                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{url('admin/product/'.$product->id.'/edit')}}" class="btn btn-warning w-100">Edit</a>
                                </div>
                                <form action="{{url('admin/product/'.$product->id)}}" method="post" class="col-sm-6">
                                    @csrf 
                                    @method('DELETE')
                                    <button class="btn btn-danger w-100">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>         
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

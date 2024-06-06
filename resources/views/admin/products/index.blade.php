@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card overlfow-x-auto">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link" href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="hstack mb-3">
                        <a href="{{url('admin/product/create')}}" class="btn btn-success ms-auto">+ Add new Product</a>
                    </div>

                    <div class="w-100 overflow-x-auto"> 
                        <table class="table table-striped align-items-center align-baseline text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Details</th>
                                    <th scole="col">Edit</th>
                                    <th scole="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td><img class="rounded" width="100px" src="{{asset('public/images/products').'/'.$product->image}}" alt="no-image"></td>
                                        <td class="text-truncate" style="max-width: 150px;">{{$product->name}}</td>
                                        <td class="text-truncate" style="max-width: 150px;"><a href="{{url('admin/category')}}/{{$product->category->id}}">{{$product->category->name}}</a></td>
                                        <td>{{$product->price}}</td>    
                                        <td class="text-truncate" style="max-width: 150px;">{{$product->description}}</td>
                                        <td style="max-width:100px" >
                                            @if($product->stock === 0)
                                                <div class="alert alert-danger">
                                                    {{$product->stock}}
                                                </div>
                                            @elseif ($product->stock <=5)
                                                <div class="alert alert-warning">
                                                    {{$product->stock}}
                                                </div>
                                            @else
                                                <div class="alert alert-success">
                                                    {{$product->stock}}
                                                </div>
                                            @endif
                                        </td>
                                        <td><a href="{{url('admin/product/'.$product->id)}}" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a></td>
                                        <td><a href="{{url('admin/product/'.$product->id.'/edit')}}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a></td>
                                        <td>
                                            <form action="{{url('admin/product/'.$product->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

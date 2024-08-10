@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card overlfow-x-auto">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Products'
])
        </div>
        <div class="card-body ">
            @include('employee.includes.alerts')

            <div class="hstack mb-3">
                <a href="{{route('products.create')}}" class="btn btn-success ms-auto">+ Add new Product</a>
            </div>
            @if ($products->count() === 0)
                <div class="alert alert-warning" role="alert">
                    No Products were found.
                </div>
            @else
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
                                    <td><img class="rounded" width="100px"
                                            src="{{asset('images/products') . '/' . $product->image}}" alt="no-image"></td>
                                    <td class="text-truncate" style="max-width: 150px;">{{$product->name}}</td>
                                    <td class="text-truncate" style="max-width: 150px;"><a
                                            href="{{route('categories.show', $product->category->id)}}">{{$product->category->name}}</a>
                                    </td>
                                    <td>{{$product->price}}</td>
                                    <td class="text-truncate" style="max-width: 150px;">{{$product->description}}</td>
                                    <td style="max-width:100px">
                                        @if($product->stock === 0)
                                            <div class="alert alert-danger">
                                                {{$product->stock}}
                                            </div>
                                        @elseif ($product->stock <= 5)
                                            <div class="alert alert-warning">
                                                {{$product->stock}}
                                            </div>
                                        @else
                                            <div class="alert alert-success">
                                                {{$product->stock}}
                                            </div>
                                        @endif
                                    </td>
                                    <td><a href="{{route('products.show', $product->id)}}" class="btn btn-primary"><i
                                                class="fa-solid fa-circle-info"></i></a></td>
                                    <td><a href="{{route('products.edit', $product->id)}}" class="btn btn-warning"><i
                                                class="fa-solid fa-pen-to-square"></i></a></td>
                                    <td>
                                        <form action="{{route('products.destroy', $product->id)}}" method="post">
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
            @endif
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link" href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="bar text-end mb-3">
                        <a href="{{url('admin/category/create')}}" class="btn btn-success">+ Add new Category</a>
                    </div>
                    @if ($categories->count() === 0)
                        <div class="alert alert-warning" role="alert">
                            No categories were found.
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Nr. of products</th>
                                    <th scope="col" class="text-center" colspan="3">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>{{$category->products->count()}}</td>
                                        <td><a class="btn btn-primary" href="">View Products</a> </td>
                                        <td><a class="btn btn-warning" href="{{url('admin/category/'.$category->id.'/edit')}}">Edit</a> </td>
                                        <td>
                                            <form action="{{url('/admin/category/'.$category->id)}}" method="post">
                                                @csrf 
                                                @method('DELETE')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$categories->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

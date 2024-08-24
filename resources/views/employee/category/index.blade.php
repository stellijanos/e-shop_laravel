@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Categories'])
    </div>
    <div class="card-body">
        <div class="bar text-end mb-3">
            <a href="{{route('categories.create')}}" class="btn btn-success">+ Add new Category</a>
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
                            <td><a class="btn btn-warning" href="{{route('categories.edit', $category->id)}}">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('categories.destroy', $category->id)}}" method="post">
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
@endsection
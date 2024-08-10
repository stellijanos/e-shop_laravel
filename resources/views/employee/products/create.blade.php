@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
        @include('employee.includes.breadcrumb', [
    'current' => 'Create',
    'group' => 'products',
])
        </div>
        <div class="card-body overflow-x-auto" style="height:70vh">
            @include('employee.includes.alerts')
            <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Name:</span>
                    <input class="form-control w-50" type="text" id="name" name="name" placeholder="Ex. Phone" required>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Category:</span>
                    <select name="category" id="category" class="form-select">
                        <option value="" disabled selected>Choose one</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Price: $</span>
                    <input class="form-control" type="number" min="0" max="5000000" step="0.01" id="price" name="price"
                        placeholder="Ex. 10.99" required>
                </div>
                <div class="mb-3 w-50">
                    <textarea class="form-control" type="textarea" name="description" placeholder="Description"
                        style="height:150px;" required></textarea>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Stock: </span>
                    <input type="number" min="0" class="form-control" id="stock" name="stock"
                        placeholder="Nr. products on stock" required>
                </div>
                <div class="mb-3 w-50">
                    <label for="image">Image (max: 2MB; .jpg, jpeg, .png)</label>
                    <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
                </div>

                <div class="mb-3 w-50" id="specs">
                    <label>Product specs</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Name;Value</span>
                        <input type="text" class="form-control" name="specs[]" placeholder="Ex. color;blue">
                        <span class="input-group-text btn btn-danger remove-spec" style="cursor:pointer"><i class="fa-solid fa-trash-can"></i></span>
                    </div>
                </div>
                <div class="button mb-5 text-center w-50">
                    <button type="button" class="btn btn-secondary w-100" id="add-spec-btn">Add another spec</button>
                </div>
                <button type="submit" class="btn btn-success w-50">Create product</button>
            </form>
        </div>
    </div>
</div>
@endsection
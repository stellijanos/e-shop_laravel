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
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                    <form action="{{url('admin/product')}}/{{$product->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name:</span>
                            <input class="form-control w-50" type="text" id="name" name="name" value="{{$product->name}}" placeholder="Name" required>
                        </div>
                        <div class="input-group mb-3 w-50">
                            <span class="input-group-text">Category:</span>
                            <select name="category" id="category" class="form-select">
                                <option value="" disabled>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{$product->category->id === $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3 w-50">
                            <span class="input-group-text">Price: $</span>
                            <input class="form-control" type="number" min="0" max="5000000" step="0.01" id="price" name="price" value="{{$product->price}}" placeholder="Price" required>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            
                            <textarea class="form-control" type="textarea" name="description" placeholder="Description" style="height:150px;" required>{{$product->description}}</textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="input-group mb-3 w-50">
                            <span class="input-group-text">Stock: </span>
                            <input type="number" min="0" class="form-control" id="stock" name="stock" value="{{$product->stock}}" placeholder="Nr. products on stock" required>
                        </div>
                        <div class="mb-3 w-50 text-center">
                            <img src="{{asset('public/images/products')}}/{{$product->image}}" class="rounded" width="300px" alt="{{$product->name}}-image">
                            
                            @if($product->image !== 'no-image.png')
                                <figcaption class="text-center mt-3">
                                    <input type="checkbox" class="form-check-input mt-1 mx-2" name="remove_image" id="remove-image">
                                    <label for="remove-image">Remove image</label>
                                </figcaption>
                            @endif
                        </div>
                        <div class="mb-3 w-50">
                            <label for="image">Change Image (max: 2MB; .jpg, jpeg, .png)</label>
                            <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">
                        </div>
                        <div class="mb-3 w-50" id="specs">
                            <label>Product specs</label>
                            @foreach ($product->specs as $spec)
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Name;Value</span>
                                    <input type="text" class="form-control" name="specs[]" value="{{$spec->name}};{{$spec->value}}" placeholder="Ex. color;blue">
                                    <span class="input-group-text btn btn-danger" style="cursor:pointer" onclick="removeInputGroup(this)"><i class="fa-solid fa-trash-can"></i></span>
                                </div>
                            @endforeach
                        </div>
                        <div class="button mb-5 text-center w-50">
                            <button type="button" class="btn btn-secondary w-100" id="add-spec-btn">Add another spec</button>
                        </div>
                        <button type="submit" class="btn btn-success w-50">Update product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('public/js/admin/product.js')}}"></script>
@endsection

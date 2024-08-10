@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Edit',
    'group' => 'products',
    'id' => $product->id,
])
        </div>
        <div class="card-body">
            <div id="alert" class="top-middle"></div>
            <form id="update-form" action="{{route('products.update', $product->id)}}">
                @method('PUT') 
                <div class="input-group mb-3">
                    <span class="input-group-text">Name:</span>
                    <input class="form-control w-50" type="text" id="name" name="name" value="{{$product->name}}"
                        placeholder="Name" required>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Category:</span>
                    <select name="category" id="category" class="form-select">
                        <option value="" disabled>Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{$product->category->id === $category->id ? 'selected' : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Price: $</span>
                    <input class="form-control" type="number" min="0" max="5000000" step="0.01" id="price" name="price"
                        value="{{$product->price}}" placeholder="Price" required>
                </div>
                <div class="form-floating mb-3 w-50">

                    <textarea class="form-control" type="textarea" name="description" placeholder="Description"
                        style="height:150px;" required>{{$product->description}}</textarea>
                    <label for="description">Description</label>
                </div>
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Stock: </span>
                    <input type="number" min="0" class="form-control" id="stock" name="stock"
                        value="{{$product->stock}}" placeholder="Nr. products on stock" required>
                </div>
                <div class="mb-3 w-50 text-center">
                    <img id="show-image" src="{{asset('images/products')}}/{{$product->image}}" class="rounded" width="300px"
                        alt="{{$product->name}}-image">

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
                            <input type="text" class="form-control" name="specs[]" value="{{$spec->name}};{{$spec->value}}"
                                placeholder="Ex. color;blue">
                            <span class="input-group-text btn btn-danger remove-spec" style="cursor:pointer"><i
                                    class="fa-solid fa-trash-can"></i></span>
                        </div>
                    @endforeach
                </div>
                <div class="button mb-5 text-center w-50">
                    <button type="button" class="btn btn-secondary w-100" id="add-spec-btn">Add another spec</button>
                </div>
                <button type="submit" id="update-btn" class="btn btn-success w-50">Update product</button>
            </form>
        </div>
    </div>
</div>
@endsection
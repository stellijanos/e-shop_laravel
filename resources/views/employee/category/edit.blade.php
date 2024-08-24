@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Edit', 'group' => 'categories', 'id' => $category->id])
    </div>
    <div class="card-body">
        <form id="update-form" action="{{route('categories.update', $category->id)}}">
            @csrf
            @method('PUT')
            <div class="form-floating mb-3">
                <input class="form-control w-50" type="text" id="name" name="name" value="{{$category->name}}"
                    placeholder="Name">
                <label for="name">Name</label>
            </div>

            <button type="submit" id="update-btn" data-id="{{$category->id}}" class="btn btn-success w-50">Update
                category</button>
        </form>
    </div>
</div>
@endsection
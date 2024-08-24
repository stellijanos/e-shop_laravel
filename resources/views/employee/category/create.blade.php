@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Create', 'group' => 'categories',])
    </div>
    <div class="card-body">
        <form action="{{route('categories.store')}}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control w-50" type="text" id="name" name="name" placeholder="Name">
                <label for="name">Name</label>
            </div>

            <button type="submit" class="btn btn-success w-50">Create category</button>
        </form>
    </div>
</div>
@endsection
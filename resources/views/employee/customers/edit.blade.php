@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Edit',
    'group' => 'customers',
    'id' => $customer->id,
])
        </div>
        <div class="card-body">
            <div id="alert" class="top-middle"></div>
            <form id="update-form" action="{{route('customers.update', $customer->id)}}">
                @method('PUT')
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="firstname" name="firstname"
                        value="{{$customer->firstname}}" placeholder="Firstname">
                    <label for="firstname">Firstname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="lastname" name="lastname"
                        value="{{$customer->lastname}}" placeholder="Lastname">
                    <label for="lastname">Lastname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="email" name="email" value="{{$customer->email}}"
                        placeholder="Email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <button type="submit" id="update-btn" data-id="{{$customer->id}}" class="btn btn-success w-50">Update
                    customer</button>
            </form>
        </div>
    </div>
</div>
@endsection
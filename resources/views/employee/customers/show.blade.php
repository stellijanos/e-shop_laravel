@extends('layouts.app')
@section('content')
@include('employee.style')  
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb',[
                'current' => 'Details',
                'group' => 'customers'
                ])
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger w-50" role="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </div>
            @endif
            <div class="details mx-3">
                <p>Customer #{{$customer->id}}</p>
                <p>Position: {{$customer->role}}</p>
                <p>Firstname: {{$customer->firstname}}</p>
                <p>Lastname: {{$customer->lastname}}</p>
                <p>Email: {{$customer->email}}</p>
                <p>Hired since: {{date('d.m.Y', strtotime($customer->created_at))}}</p>

                <p>Address</p>
            </div>

            <div class="row">
                <div class="mb-3">
                    <a href="{{route('customers.edit', $customer->id)}}" class="btn btn-warning w-25">Edit</a>
                </div>
                <form action="{{route('customers.destroy', $customer->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-25">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
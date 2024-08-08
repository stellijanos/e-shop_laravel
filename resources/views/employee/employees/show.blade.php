@extends('layouts.app')
@section('content')

@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Details',
    'group' => 'employees',
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
                <p>Employee #{{$employee->id}}</p>
                <p>Position: {{$employee->role}}</p>
                <p>Firstname: {{$employee->firstname}}</p>
                <p>Lastname: {{$employee->lastname}}</p>
                <p>Email: {{$employee->email}}</p>
                <p>Hired since: {{date('d.m.Y', strtotime($employee->created_at))}}</p>

                <p>Address</p>
            </div>

            <div class="row">
                <div class="mb-3">
                    <a href="{{route('employees.edit', $employee->id)}}" class="btn btn-warning w-25">Edit</a>
                </div>
                <form action="{{route('employees.update', $employee->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-25">Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection
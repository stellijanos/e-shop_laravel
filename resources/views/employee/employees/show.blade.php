@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Details', 'group' => 'employees'])
    </div>
    <div class="card-body">

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
@endsection
@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Employees'])
    </div>
    <div class="card-body">

        <div class="hstack mb-3">
            <a href="{{route('employees.create')}}" class="btn btn-success ms-auto">+ Add new Employee</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Hired since</th>
                    <th scole="col">Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{$employee->id}}</td>
                        <td>{{$employee->firstname}}</td>
                        <td>{{$employee->lastname}}</td>
                        <td><a href="mailto:{{$employee->email}}">{{$employee->email}}</a></td>
                        <td>{{$employee->role}}</td>
                        <td>{{date('d.m.Y', strtotime($employee->created_at))}}</td>
                        <td><a href="{{route('employees.show', [$employee->id])}}" class="btn btn-primary">More
                                details</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$employees->links()}}
    </div>
</div>
@endsection
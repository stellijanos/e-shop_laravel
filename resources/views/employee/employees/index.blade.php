@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="nav-link" href="{{route('admin.index')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employees</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="hstack mb-3">
                        <a href="{{url('admin/employee/create')}}" class="btn btn-success ms-auto">+ Add new Employee</a>
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
                                    <td><a href="{{url('admin/employee/'.$employee->id)}}" class="btn btn-primary">More details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$employees->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

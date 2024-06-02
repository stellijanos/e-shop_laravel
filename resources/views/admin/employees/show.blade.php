
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
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('admin/employee')}}">Employees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                    <div class="details mx-3">
                        <p>Employee #{{$employee->id}}</p>
                        <p>Position: {{$employee->role}}</p>
                        <p>Firstname: {{$employee->firstname}}</p>
                        <p>Lastname: {{$employee->lastname}}</p>
                        <p>Email: {{$employee->email}}</p>
                        <p>Hired since: {{date('d.m.Y',strtotime($employee->created_at))}}</p>

                        <p>Address</p>
                    </div>

                    <div class="options">
                    <a href="{{url('admin/employee/'.$employee->id.'/edit')}}" class="btn btn-warning w-25 mx-3">Edit</a>
                    <a class="btn btn-danger w-25">Delete</a>
                    </div>
                                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

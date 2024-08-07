
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
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('admin/customer')}}">Customers</a></li>
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
                        <p>Customer #{{$customer->id}}</p>
                        <p>Position: {{$customer->role}}</p>
                        <p>Firstname: {{$customer->firstname}}</p>
                        <p>Lastname: {{$customer->lastname}}</p>
                        <p>Email: {{$customer->email}}</p>
                        <p>Hired since: {{date('d.m.Y',strtotime($customer->created_at))}}</p>

                        <p>Address</p>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <a href="{{url('admin/customer/'.$customer->id.'/edit')}}" class="btn btn-warning w-25">Edit</a>
                        </div>
                        <form action="{{url('admin/customer/'.$customer->id)}}" method="post">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-danger w-25">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

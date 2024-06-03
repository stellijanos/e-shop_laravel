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
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                    <form action="{{url('admin/customer/'.$customer->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-floating mb-3">
                            <input class="form-control w-50" type="text" id="firstname" name="firstname" value="{{$customer->firstname}}" placeholder="Firstname">
                            <label for="firstname">Firstname</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="text" id="lastname" name="lastname" value="{{$customer->lastname}}" placeholder="Lastname">
                            <label for="lastname">Lastname</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="text" id="email" name="email" value="{{$customer->email}}" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-success w-50">Update customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
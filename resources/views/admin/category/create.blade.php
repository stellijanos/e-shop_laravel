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
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('admin/category')}}">Categories</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                    <form action="{{url('admin/category')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input class="form-control w-50" type="text" id="name" name="name" placeholder="Name">
                            <label for="name">Name</label>
                        </div>
       
                        <button type="submit" class="btn btn-success w-50">Create category</button>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

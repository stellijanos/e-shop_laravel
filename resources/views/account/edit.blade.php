

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center g-3">
        @include('account.sidebar')
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Edit Account') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success w-50" role="alert">
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
                    <form action="{{route('account.edit')}}" method="post">
                        @csrf 
                        @method('PUT')
                        <div class="form-floating mb-3">
                            <input class="form-control w-50" type="text" id="firstname" name="firstname" value="{{auth()->user()->firstname}}" placeholder="Firstname">
                            <label for="firstname">Firstname</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="text" id="lastname" name="lastname" value="{{auth()->user()->lastname}}" placeholder="Lastname">
                            <label for="lastname">Lastname</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="text" id="email" autocomplete="username" name="email" value="{{auth()->user()->email}}" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="password" id="password" autocomplete="current-password" name="password" placeholder="Firstname">
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-success w-50">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center g-3">
        @include('account.sidebar')
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Delete Account</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger w-50" role="alert">
                            @foreach ($errors->all() as $error )
                                <li>{{$error}}</li>
                            @endforeach
                        </div>
                    @endif
                    <form action="{{route('account.delete')}}" method="post">
                        @csrf 
                        @method('DELETE')
                        <div class="form-floating mb-3 w-50">
                            <input class="form-control" type="password" id="password" value="" name="password" placeholder="Firstname">
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-danger w-50">Permanently delete my account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

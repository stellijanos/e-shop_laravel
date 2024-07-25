
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center g-3">
        @include('account.sidebar')
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Account details') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Firstname: {{auth()->user()->firstname}}</p>
                    <p>Lastname: {{auth()->user()->lastname}}</p>
                    <p>Email: {{auth()->user()->email}}</p>
                    <p>Phone: {{auth()->user()->phone}}</p>
                    <p>Client since: {{date('d-m-Y',strtotime(auth()->user()->created_at))}}</p>
                    <a type="button" class="btn btn-warning" href="{{url('account/edit')}}">Edit Account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

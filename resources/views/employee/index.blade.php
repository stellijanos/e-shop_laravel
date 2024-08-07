@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        
                        <div class="col-md-2 text-center">
                            <a href="{{route('employees.index')}}" class="nav-link option">
                                <img src="{{asset('images/employees.png')}}" alt="employees" width="100px;">
                                <p>Employees</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{route('employees.customers')}}" class="nav-link option">
                                <img src="{{asset('images/users.png')}}" alt="users" width="100px;">
                                <p>Customers</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{route('employees.categories')}}" class="nav-link option">
                                <img src="{{asset('images/categories.png')}}" alt="products" width="100px;">
                                <p>Categories</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{route('employees.products')}}" class="nav-link option">
                                <img src="{{asset('images/products.png')}}" alt="products" width="100px;">
                                <p>Products</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="" class="nav-link option">
                                <img src="{{asset('images/orders.png')}}" alt="orders" width="100px;">
                                <p>Orders</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="" class="nav-link option">
                                <img src="{{asset('images/reports.png')}}" alt="reports" width="100px;">
                                <p>Reports</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

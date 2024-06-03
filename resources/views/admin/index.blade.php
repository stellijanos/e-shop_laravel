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
                            <a href="{{url('admin/employee')}}" class="nav-link option">
                                <img src="{{asset('public/images/employees.png')}}" alt="employees" width="100px;">
                                <p>Employees</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{url('admin/customer')}}" class="nav-link option">
                                <img src="{{asset('public/images/users.png')}}" alt="users" width="100px;">
                                <p>Customers</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{url('admin/category')}}" class="nav-link option">
                                <img src="{{asset('public/images/categories.png')}}" alt="products" width="100px;">
                                <p>Categories</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="" class="nav-link option">
                                <img src="{{asset('public/images/products.png')}}" alt="products" width="100px;">
                                <p>Products</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="" class="nav-link option">
                                <img src="{{asset('public/images/orders.png')}}" alt="orders" width="100px;">
                                <p>Orders</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="" class="nav-link option">
                                <img src="{{asset('public/images/reports.png')}}" alt="reports" width="100px;">
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

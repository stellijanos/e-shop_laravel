@extends('layouts.app')

@section('content')

@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="d-flex justify-content-around flex-wrap">

                <div class="text-center option">
                    <a href="{{route('employees.index')}}" class="nav-link option">
                        <img src="{{asset('images/employees.png')}}" alt="employees" width="100px;">
                        <p>Employees</p>
                    </a>
                </div>
                <div class="text-center option">
                    <a href="{{route('customers.index')}}" class="nav-link option">
                        <img src="{{asset('images/users.png')}}" alt="users" width="100px;">
                        <p>Customers</p>
                    </a>
                </div>
                <div class="text-center option">
                    <a href="{{route('categories.index')}}" class="nav-link option">
                        <img src="{{asset('images/categories.png')}}" alt="products" width="100px;">
                        <p>Categories</p>
                    </a>
                </div>
                <div class="text-center option">
                    <a href="{{route('products.index')}}" class="nav-link option">
                        <img src="{{asset('images/products.png')}}" alt="products" width="100px;">
                        <p>Products</p>
                    </a>
                </div>
                <div class="text-center option">
                    <a href="{{route('products.index')}}" class="nav-link option">
                        <img src="{{asset('images/orders.png')}}" alt="orders" width="100px;">
                        <p>Orders</p>
                    </a>
                </div>
                <div class="text-center option">
                    <a href="{{route('reports.index')}}" class="nav-link option">
                        <img src="{{asset('images/reports.png')}}" alt="reports" width="100px;">
                        <p>Reports</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
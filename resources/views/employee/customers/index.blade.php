@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Customers'
])
        </div>
        <div class="card-body">
            @include('employee.includes.alerts')

            @if ($customers->count() === 0)
                <div class="alert alert-warning" role="alert">
                    No customers were found.
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Email</th>
                            <th scope="col">Customer since</th>
                            <th scole="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{$customer->id}}</td>
                                <td>{{$customer->firstname}}</td>
                                <td>{{$customer->lastname}}</td>
                                <td><a href="mailto:{{$customer->email}}">{{$customer->email}}</a></td>
                                <td>{{date('d.m.Y', strtotime($customer->created_at))}}</td>
                                <td><a href="{{route('customers.show', $customer->id)}}" class="btn btn-primary">More
                                        details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$customers->links()}}
            @endif
        </div>
    </div>
</div>
@endsection
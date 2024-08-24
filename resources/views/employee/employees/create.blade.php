@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Create', 'group' => 'employees'])
    </div>
    <div class="card-body overflow-x-auto" style="height:70vh">
        <form action="{{route('employees.create')}}" method="post">
            @csrf
            <div class="form-floating mb-3 w-50">
                <select name="role" id="role" class="form-select">
                    <option value="admin" selected>Admin</option>
                    <option value="E-commerce Manager">E-commerce Manager</option>
                    <option value="Marketing Manager">Marketing Manager</option>
                    <option value="Product Manager">Product Manager</option>
                    <option value="Customer Service Representative">Customer Service Representative</option>
                    <option value="Warehouse Manager">Warehouse Manager</option>
                    <option value="Web Developer">Web Developer</option>
                    <option value="Content Writer">Content Writer</option>
                    <option value="Graphic Designer">Graphic Designer</option>
                    <option value="Data Analyst">Data Analyst</option>
                    <option value="Financial Manager">Financial Manager</option>
                </select>
                <label for="role">Select role</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control w-50" type="text" id="firstname" name="firstname" placeholder="Firstname">
                <label for="firstname">Firstname</label>
            </div>
            <div class="form-floating mb-3 w-50">
                <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Lastname">
                <label for="lastname">Lastname</label>
            </div>
            <div class="form-floating mb-3 w-50">
                <input class="form-control" type="email" id="email" name="email" placeholder="Email">
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3 w-50">
                <input class="form-control" type="text" id="phone" name="phone" placeholder="Phone">
                <label for="phone">Phone</label>
            </div>
            <div class="form-floating mb-3 w-50">
                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3 w-50">
                <input class="form-control" type="password" id="confirm-password" name="confirm_password"
                    placeholder="Confirm Password">
                <label for="confirm-password">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-success w-50">Create employee</button>
        </form>
    </div>
</div>
@endsection
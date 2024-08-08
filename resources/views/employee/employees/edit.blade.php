@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Edit',
    'group' => 'employees',
    'id' => $employee->id,
])
        </div>
        <div class="card-body">
            <div class="alert alert-success" role="alert">
            </div>
            <div class="alert alert-danger" role="alert">
            </div>

            <form id="update-employee">
                @csrf
                <div class="form-floating mb-3 w-50">
                    <select name="role" id="role" class="form-select">
                        <option value="admin">Admin</option>
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
                    <input class="form-control w-50" type="text" id="firstname" name="firstname"
                        value="{{$employee->firstname}}" placeholder="Firstname">
                    <label for="firstname">Firstname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="lastname" name="lastname"
                        value="{{$employee->lastname}}" placeholder="Lastname">
                    <label for="lastname">Lastname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="email" id="email" name="email" value="{{$employee->email}}"
                        placeholder="Email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="phone" name="phone" value="{{$employee->phone}}"
                        placeholder="Phone">
                    <label for="phone">Phone</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <button type="submit" class="btn btn-success w-50">Update employee</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $('.alert').hide();

    function customAlert(message) {
        return $('<div>', {
            class: 'custom-alert',
            style: 'z-index:99999',
            html: '<p>' + message + '</p><button id="closeAlert">OK</button>'
        });
    }

    $('#update-employee').on('submit', function (e) {
        e.preventDefault();

        $('.alert').hide();

        $.ajax({
            url: '{{route('employees.update', $employee->id)}}',
            type: 'PUT',
            data: $(this).serialize(),
            success: function (res) {
                $('.alert-success').show();
                $('.alert-success').html(res.message);
            },
            error: function (err) {
                $('.alert-danger').show();
                $('.alert-danger').html(err.responseJSON.message);
                console.log(err.responseJSON);
            }
        })
    });
</script>
@endsection
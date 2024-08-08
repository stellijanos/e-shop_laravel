@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Edit',
    'group' => 'customers',
    'id' => $customer->id,
])
        </div>
        <div class="card-body">
            <div class="alert alert-success" role="alert"></div>
            <div class="alert alert-danger" role="alert"></div>
            <form id="update-customer">
                @csrf
                @method('PUT')

                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="firstname" name="firstname"
                        value="{{$customer->firstname}}" placeholder="Firstname">
                    <label for="firstname">Firstname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="lastname" name="lastname"
                        value="{{$customer->lastname}}" placeholder="Lastname">
                    <label for="lastname">Lastname</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="text" id="email" name="email" value="{{$customer->email}}"
                        placeholder="Email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3 w-50">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <button type="submit" class="btn btn-success w-50">Update customer</button>
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

    $('#update-customer').on('submit', function (e) {
        e.preventDefault();

        $('.alert').hide();

        $.ajax({
            url: '{{route('customers.update', $customer->id)}}',
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
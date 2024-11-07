@extends('layouts.employee')
@section('content.employee')
<div class="card">
    <div class="card-header">
        @include('employee.includes.breadcrumb', ['current' => 'Vouchers'])
    </div>
    <div class="card-body">

        <div class="bar text-end mb-3">
            <a href="{{route('vouchers.create')}}" class="btn btn-success">+ Add new Voucher</a>
        </div>
        @if ($vouchers->count() === 0)
            <div class="alert alert-warning" role="alert">
                No vouchers were found.
            </div>
        @else
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">From</th>
                        <th scope="col">Until</th>
                        <th scope="col">Active</th>
                        <th scope="col" class="text-center">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{$voucher->id}}</td>
                            <td>{{$voucher->name}}</td>
                            <td>{{\Carbon\Carbon::parse($voucher->start_date)->format('Y.m.d H:i:s')}}</td>
                            <td>{{\Carbon\Carbon::parse($voucher->end_date)->format('Y.m.d H:i:s')}}</td>
                            <td>
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input voucher-active-switch" type="checkbox" role="switch"
                                        data-voucher-id="{{$voucher->id}}" {{$voucher->active ? 'checked' : ''}}>
                                </div>
                            </td>
                            <td>
                                <form class="input-group rounded w-100 d-flex justify-content-center" action="{{route('vouchers.destroy', $voucher->id)}}" method="post" >
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-warning input-group-text rounded-start text-center"
                                        href="{{route('vouchers.edit', $voucher->id)}}"><i class="bi bi-pencil-square"></i></a>
                                    <button class="btn btn-danger input-group-text"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$vouchers->links()}}
        @endif
    </div>
</div>
@endsection
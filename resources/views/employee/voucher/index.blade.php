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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center" colspan="3">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                        <tr>
                            <td>{{$voucher->id}}</td>
                            <td>{{$voucher->name}}</td>
                            <td><a class="btn btn-warning" href="{{route('vouchers.edit', $voucher->id)}}">Edit</a>
                            </td>
                            <td>
                                <form action="{{route('vouchers.destroy', $voucher->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$vouchers->links()}}
        @endif
    </div>
</div>
@endsection
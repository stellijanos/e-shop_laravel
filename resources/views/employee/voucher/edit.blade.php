@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', ['current' => 'Edit', 'group' => 'vouchers', 'id' => $voucher->id])
        </div>
        <div class="card-body">
            <div id="alert" class="top-middle"></div>
            <form id="update-form" action="{{route('vouchers.update', $voucher->id)}}">
                @csrf
                @method('PUT')
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="name" name="name" value="{{$voucher->name}}">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="code" name="code" value="{{$voucher->code}}">
                    <label for="code">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="textarea" id="description" name="description"
                        value="{{$voucher->description}}">
                    <label for="description">Description</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="discount_type" class="form-select w-50" id="discount_type"
                        value="{{$voucher->discount_type}}">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed (number)</option>
                    </select>
                    <label for="discount_type">Discount type</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="number" min="1" id="value" name="value"
                        value="{{$voucher->value}}">
                    <label for="value">Value</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="date" id="start_date" name="start_date"
                        value="{{ date('Y-m-d', strtotime($voucher->start_date))}}">
                    <label for="start_date">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="date" id="end_date" name="end_date"
                        value="{{ date('Y-m-d', strtotime($voucher->end_date));}}">
                    <label for="end_date">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="number" min="1" id="usage_limit" name="usage_limit"
                        value="{{$voucher->usage_limit}}">
                    <label for="usage_limit">Usage limit (min. 1)</label>
                </div>

                <button type="submit" id="update-btn" data-id="{{$voucher->id}}" class="btn btn-success w-50">Update
                    voucher</button>
            </form>
        </div>
    </div>
</div>
@endsection
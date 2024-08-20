@extends('layouts.app')
@section('content')
@include('employee.style')
<div class="container">
    <div class="card">
        <div class="card-header">
            @include('employee.includes.breadcrumb', [
    'current' => 'Create',
    'group' => 'vouchers',
])
        </div>
        <div class="card-body">
            @include('employee.includes.alerts')
            <form action="{{route('vouchers.store')}}" method="post">
                @csrf
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="name" name="name" value="{{old('name')}}">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="text" id="code" name="code" value="{{old('code')}}">
                    <label for="code">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="textarea" id="description" name="description"
                        value="{{old('description')}}">
                    <label for="description">Description</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="discount_type" class="form-select w-50" id="discount_type"
                        value="{{old('discount_type')}}">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed (number)</option>
                    </select>
                    <label for="discount_type">Discount type</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="number" min="1" id="value" name="value"
                        value="{{old('value')}}">
                    <label for="value">Value</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="date" id="start_date" name="start_date"
                        value="{{old('start_date')}}">
                    <label for="start_date">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="date" id="end_date" name="end_date"
                        value="{{old('end_date')}}">
                    <label for="end_date">Code</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control w-50" type="number" min="1" id="usage_limit" name="usage_limit"
                        value="{{old('usage_limit')}}">
                    <label for="usage_limit">Usage limit (min. 1)</label>
                </div>
                <button type="submit" class="btn btn-success w-50">Create voucher</button>
            </form>
        </div>
    </div>
</div>

@endsection
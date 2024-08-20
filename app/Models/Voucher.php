<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'discount_type', // percentage / fixed
        'value',
        'start_date',
        'end_date',
        'usage_limit',
        'times_used',
        'active'
    ];

    public function user()
    {
        return $this->hasOne(Customer::class, 'voucher_id', 'id')
            ->join('shopping_session_vouchers', 'users.id', '=', 'cart_vouchers.user_id')
            ->whereColumn('cart_vouchers.voucher_id', 'vouchers.id');
    }
}

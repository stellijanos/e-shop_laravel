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
}

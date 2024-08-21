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
        return $this->belongsToMany(Customer::class, 'shopping_session_vouchers', 'user_id', 'voucher_id')
            ->withTimestamps();
    }



    // other functions

    public function isActive()
    {
        return $this->active;
    }


    public function isExpired()
    {
        $start_date = new \DateTime($this->start_date);
        $end_date = new \DateTime($this->end_date);
        $now = new \DateTime();

        return $now < $start_date || $now > $end_date;
    }



    public function incTimesUsed()
    {
        $this->times_used++;
        $this->save();
    }

    public function decTimesUsed()
    {
        $this->times_used--;
        $this->save();
    }
}

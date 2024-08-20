<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'phone',
        'status',
        'payment',
        'shipping_fee',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
    
    public function address(): BelongsTo {
        return $this->belongsTo(Address::class);
    }

    public function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

}

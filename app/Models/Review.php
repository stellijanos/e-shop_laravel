<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'description'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'id')->select(['id', 'firstname', 'lastname']);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}

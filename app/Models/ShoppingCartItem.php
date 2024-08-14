<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $table = 'shopping_session_products';

    protected $primaryKey = ['user_id', 'product_id'];
    public $incrementing = false;
    protected $keyType = 'string';


    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}

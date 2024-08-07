<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $table = 'shopping_session_products';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function user():BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function product():BelongsTo {
        return $this->belongsTo(Product::class);
    }
  
}

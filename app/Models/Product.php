<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'description',
        'image',
        'stock',
    ];
    
    
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function productSpecs(): HasMany {
        return $this->hasMany(ProductSpec::class);
    }

    public function usersFavourited(): BelongsToMany {
        return $this->belongsToMany(User::class, 'favourites', 'product_id', 'user_id');
    }

    public function shoppingSessions(): BelongsToMany {
        return $this->belongsToMany(User::class, 'shopping_session_products')->withPivot('quantity');
    }

}

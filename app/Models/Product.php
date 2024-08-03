<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class);
    }

    public function usersFavourited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourites', 'product_id', 'user_id');
    }

    public function shoppingSessions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shopping_session_products')->withPivot('quantity');
    }


    public function scopeCategories(Builder $query, array $ids)
    {
        if (count($ids))
            $query->whereIn('category_id', $ids);
        return $query;
    }

    public function scopeFilter(Builder $query, array $filters)
    {

        foreach ($filters as $filter => $values) {
            $query->whereHas('specs', function (Builder $query) use ($filter, $values) {
                $query->Where('name', $filter)->whereIn('value', $values);
            });
        }
        // dd($query->toSql());
        return $query;
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = ['user_id', 'product_id'];
    public $incrementing = false;

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


    public static function getByUserAndProduct(User $user, Product $product)
    {
        return self::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
    }

    public static function updateReview(User $user, Product $product, $data)
    {
        self::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->update($data);

        return self::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
    }


    public static function deleteReview(User $user, Product $product)
    {
        return Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->delete();
    }

}

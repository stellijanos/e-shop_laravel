<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // relationships

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favourites', 'user_id', 'product_id');
    }


    public function shoppingCart(): HasMany
    {
        return $this->hasMany(ShoppingCartItem::class);
    }



    public function addFavourite($product) {
        if ($this->favourites()->where('product_id', $product->id)->exists()) {
            $this->favourites()->detach($product);
            return "removed";
        } else {
            $this->favourites()->attach($product);
            return "added";
        }
    }


    public function addToCart(Product $product) {

        $cartItem = $this->shoppingCart()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $this->shoppingCart()->where('product_id', $product->id)->increment('quantity');
        } else {
            $cartItem = new ShoppingCartItem();
            $cartItem->product_id = $product->id;
            $cartItem->user_id = $this->id;
            $cartItem->save();
        }
        return true;
    }


    public function setCartProductQuantity(Product $product, int $quantity) {

        $cartItem = $this->shoppingCart()->where('product_id', $product->id)->first();
        if (!$cartItem) {
            return "not-found"; 
        }
        
        if ($quantity > $cartItem->product->stock) {
            return "invalid-quantity";
        }

        if ($quantity === 0) {
            $this->shoppingCart()->where('product_id', $product->id)->delete();
        } else {
            $this->shoppingCart()->where('product_id', $product->id)->update(['quantity' => $quantity]);
        }

        return "success";
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Customer extends User
{
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
        return $this->hasMany(ShoppingCartItem::class, 'user_id', 'id');
    }




    // other functionalities


    public function scopeGetAllCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeGetCustomer($query, int $id)
    {
        return $query->where('id', $id)->where('role', 'customer')->first();
    }


    public function toggleFavourite($product)
    {
        if ($this->favourites()->where('product_id', $product->id)->exists()) {
            $this->favourites()->detach($product);
            return "removed";
        }

        $this->favourites()->attach($product);
        return "added";

    }

    public function addToCart(Product $product, int $quantity)
    {

        if ($quantity <= 0) {
            return "fail";
        }

        $cartItem = $this->shoppingCart()->where('product_id', $product->id)->first();
        if (!$cartItem) {

            ShoppingCartItem::create([
                'product_id' => $product->id,
                'user_id' => $this->id,
                'quantity' => $quantity
            ]);

            return "added";
        }

        if ($quantity > $cartItem->product->stock) {
            return "fail";
        }

        $this->shoppingCart()->where('product_id', $product->id)->update(['quantity' => $quantity]);
        return "added";

    }


    public function removeFromCart($product)
    {
        $cartItem = $this->shoppingCart()->where('product_id', $product->id)->first();
        if (!$cartItem) {
            return ['status' => 'fail', 'message' => 'Product not found in cart!'];
        }

        $this->shoppingCart()->where('product_id', $product->id)->delete();
        return ['status' => 'success', 'message' => 'Product deleted from cart!'];

    }

    public function getNumberOfCartProducts()
    {
        return $this->shoppingCart()->sum('quantity');
    }


    public function incrementCartItemQuantity(Product $product)
    {
        $cartItem = $this->shoppingCart()->where('product_id', $product->id);

        if ($cartItem->first()) {
            $cartItem->increment('quantity');
        } else {
            ShoppingCartItem::create([
                'product_id' => $product->id,
                'user_id' => $this->id
            ]);
        }
        return "incremented";
    }



    public function decrementCartItemQuantity(Product $product)
    {
        $cartItem = $this->shoppingCart()->where('product_id', $product->id);

        if ($cartItem->first()) {
            $this->shoppingCart()->where('product_id', $product->id)->decrement('quantity');
            if ($cartItem->first()->quantity === 0) {
                $this->shoppingCart()->where('product_id', $product->id)->delete();
            }
        } else {
            "fail";
        }
        return "decremented";
    }


}

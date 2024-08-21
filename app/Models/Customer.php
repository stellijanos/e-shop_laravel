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


    public function cartVoucher(): BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'shopping_session_vouchers', 'user_id', 'voucher_id')
            ->withTimestamps();
    }




    // other functionalities


    public function scopeGetAllCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    public static function getCustomer(int $id)
    {
        return self::where('id', $id)->where('role', 'customer')->first();
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


    public function removeFromFavourites($product)
    {
        if ($this->favourites()->where('product_id', $product->id)->exists()) {
            $this->favourites()->detach($product);
            return "removed";
        }
        return "fail";
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


    public function removeFromCart(Product $product)
    {
        $cartItem = $this->shoppingCart()->where('product_id', $product->id);
        if (!$cartItem->first()) {
            return "fail";
        }

        $cartItem->delete();
        return "success";

    }

    public function getNumberOfCartProducts()
    {
        return $this->shoppingCart()->sum('quantity');
    }


    public function getCartItem(Product $product)
    {
        return ShoppingCartItem::where('user_id', $this->id)
            ->where('product_id', $product->id)->with('product')
            ->first();
    }


    public function incrementCartItemQuantity(Product $product)
    {
        $cartItem = $this->shoppingCart()->where('product_id', $product->id);

        if ($cartItem->first()) {

            if ($cartItem->first()->quantity + 1 > $product->stock) {
                return "not_enough_in_stock";
            }
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
            if ($cartItem->first()->quantity <= 1) {
                return "min_quantity_is_1";
            }
            $cartItem->decrement('quantity');
        } else {
            "fail";
        }
        return "decremented";
    }

    public function applyVoucher(Voucher $voucher)
    {

        try {
            if ($this->cartVoucher()->exists()) {
                $this->cartVoucher()->detach();
            }
            $this->cartVoucher()->attach($voucher->id);
            return 'success';
        } catch (\Exception $e) {
            \Log::error('Failed to apply voucher: ' . $e->getMessage());
            return 'fail';
        }
    }


    public function deleteVoucher()
    {
        try {
            if ($this->cartVoucher()->exists()) {
                $this->cartVoucher()->detach();
            }
            return 'success';
        } catch (\Exception $e) {
            \Log::error('Failed to remove voucher: ' . $e->getMessage());
            return 'fail';
        }
    }



    public function getCartVoucher(): Voucher|null
    {
        return $this->cartVoucher()->first();
    }
}

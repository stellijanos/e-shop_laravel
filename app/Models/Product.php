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

    public function customersFavourited(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'favourites', 'product_id', 'user_id');
    }

    public function shoppingSessions(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'shopping_session_products')->withPivot('quantity');
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

            if ($filter === 'category') {
                $query->whereHas('category', function (Builder $query) use ($filter, $values) {
                    $query->WhereIn('name', $values);
                });
            } else {
                $query->whereHas('specs', function (Builder $query) use ($filter, $values) {
                    $query->Where('name', $filter)->whereIn('value', $values);
                });
            }

        }
        // dd($query->toSql());
        return $query;
    }



    public function scopeSortBy(Builder $query, string $sortBy)
    {
        if ($sortBy === "default")
            return $query->orderBy('id');

        $accepted = ['price-asc', 'price-desc', 'name-asc', 'name-desc'];
        if (!in_array($sortBy, $accepted))
            return $query;

        [$column, $direction] = explode('-', $sortBy);

        return $query->orderBy($column, $direction);
    }



    // other functions
    public function wasReviewedBy(int $customerId)
    {
        return $this->reviews()->where('user_id', $customerId)->where('product_id', $this->id)->exists();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    public function removeImage()
    {
        $imageName = $this->image;

        if ($imageName == 'no-image.png')
            return;
        $imagePath = public_path('images/products/') . $imageName;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function setDefaultImage()
    {
        $this->removeImage();
        $this->image = 'no-image.png';

        return $this->image;
    }



    public function changeImage($image)
    {
        $this->removeImage();

        $imageName = date('Ymdhis') . uniqid() . '.' . $image->extension();
        $image->move(public_path('images/products/'), $imageName);

        return $imageName;
    }



    public function addSpecs($specs)
    {
        $this->specs()->delete();

        foreach ($specs as $spec) {

            $spec = explode(';', $spec);

            if (count($spec) !== 2)
                continue;

            ProductSpec::create([
                'product_id' => $this->id,
                'name' => $spec[0],
                'value' => $spec[1],
            ]);
        }
    }





}

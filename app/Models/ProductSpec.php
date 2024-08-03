<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpec extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'name',
        'value'
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }


    public static function getAllSpecsGroupedByName() {
        return self::select(['name', 'value'])
        ->get()
        ->groupBy('name')
        ->map(function ($items) {
            return $items->pluck('value')->unique();
        })->toArray();
    }
}

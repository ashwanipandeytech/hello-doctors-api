<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = [
        'product_id', 'quantity', 'price', 'discount', 'tax', 'token', 'user_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

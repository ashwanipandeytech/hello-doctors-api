<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\ItemVariation
 *
 * @property int $id
 * @property int $product_id
 * @property string $oemCode
 * @property string $itemVariationName
 * @property array $variatioons
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\ItemVariationImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereItemVariationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariation whereVariatioons($value)
 * @mixin \Eloquent
 */
class ItemVariation extends Model
{
    use HasFactory;
    protected $casts = [
        'variatioons' => 'array',
    ];
    protected $table = 'item_variations';
    protected $fillable = ['product_id', 'oemCode', 'itemVariationName', 'variatioons'];

    public function images()
    {
        return $this->hasMany(ItemVariationImage::class);
    }
}

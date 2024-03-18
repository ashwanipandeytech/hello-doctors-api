<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\ItemVariationImage
 *
 * @property int $id
 * @property int $item_variation_id
 * @property string $image_path
 * @property string $name
 * @property string $image_type
 * @property-read \App\Models\Admin\ItemVariation|null $variation
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage whereItemVariationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ItemVariationImage whereName($value)
 * @mixin \Eloquent
 */
class ItemVariationImage extends Model
{
    use HasFactory;
    protected $table = 'item_variations_image';
    public $timestamps = false;
    protected $fillable = ['item_variation_id', 'image_path', 'name', 'image_type'];
    public function variation()
    {
        return $this->belongsTo(ItemVariation::class);
    }
}

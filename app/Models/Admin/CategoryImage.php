<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\CategoryImage
 *
 * @property int $id
 * @property int $category_id
 * @property string $image_path
 * @property string $name
 * @property string $image_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategoryImage extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'image_path', 'name', 'image_type'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $slug
 * @property string|null $seoTitle
 * @property string|null $seoKeywords
 * @property string|null $seoDescription
 * @property string $isMenu
 * @property string $isActive
 * @property string|null $oemCode
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property string|null $selectedTags
 * @property string|null $selectedAttributes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSelectedAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSelectedTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function nestedTree()
    {
        $tree = $this->toArray();
        $tree['children'] = $this->getNestedChildren($this->children);

        return $tree;
    }

    private function getNestedChildren($children)
    {
        $nestedChildren = [];

        foreach ($children as $child) {
            $childTree = $child->toArray();
            $subChildren = $this->getNestedChildren($child->children);

            if (!empty($subChildren)) {
                $childTree['children'] = $subChildren;
            }

            $nestedChildren[] = $childTree;
        }

        return $nestedChildren;
    }
}
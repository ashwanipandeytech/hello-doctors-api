<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\OemsSetting;
use App\Traits\OemsSettingTrait;

/**
 * App\Models\Admin\Category
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
 * @property array|null $selectedTags
 * @property array|null $selectedAttributes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\CategoryImage> $images
 * @property-read int|null $images_count
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Product> $products
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
 * @property-read int|null $parent_count
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    use OemsSettingTrait;

    protected $casts = [
        'selectedAttributes' => 'array',
        'selectedTags' => 'array',
    ];


    protected $fillable = ['name', 'parent_id','oemCode','slug','seoTitle','seoKeywords','seoDescription','shortDescription','longDescription','isMenu','isActive','selectedTags','selectedAttributes'];

    public function parent()
    {
        return $this->hasMany(Category::class, 'parent_id');
        
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function nestedTree($oemCode,  $userId,$type)
    {
        $tree = $this->toArray();
        if($this->children->isEmpty()){
            $products = $this->products;
                    $productData = [];
                    foreach ($products as $product) {
                        $productArray = $product->toArray();
                        // Fetch product images here and add them to the product data
                        $productArray['images'] = $product->images;
                        $productData[] = $productArray;
                    }
                    $tree['products'] = $productData;
        }else{
            $tree['subcategories'] = $this->getNestedChildren($this->children,$oemCode,  $userId,$type);
        }
        

        return $tree;
    }

    private function getNestedChildren($children,$oemCode,  $userId,$type)
    {
        $nestedChildren = [];

        foreach ($children as $child) {
            if ($child->oemCode !== $oemCode) {
                continue;
            }
            $childTree = $child->toArray();
            $subChildren = $this->getNestedChildren($child->children,$oemCode,  $userId,$type);

            if (!empty($subChildren)) {
                $childTree['subcategories'] = $subChildren;
            }
            if ($type == 'product') {
                    $products = $child->products;
                    $productData = [];
                    foreach ($products as $product) {
                        $productArray = $product->toArray();
                        // Fetch product images here and add them to the product data
                        $productArray['images'] = $product->images;
                        $productData[] = $productArray;
                    }
                    $childTree['products'] = $productData;
                }
            //$childTree['images'] = $child->images;
            $oemCode = $child->oemCode;
            $oemsSetting =  $this->getOemsSettingByOemCode($oemCode);;

            if ($oemsSetting) {
                $childTree['groupCode'] = $oemsSetting->groupCode;
            }
            $nestedChildren[] = $childTree;
        }
        //    $groupCodes = OemsSetting::whereIn('oems', $child->oemCode)->pluck('groupCode')->toArray();
        // $childTree['groupCodes'] = $groupCodes;
        return $nestedChildren;
    }

    public function images()
    {
        return $this->hasMany(CategoryImage::class);
    }

    // public function OemsSetting()
    // {
    //     // Assuming the foreign key between Category and oem_settings is 'group_code'
    //     return $this->belongsTo(OemsSetting::class, 'groupCode', 'oemCode')
    //         ->whereIn('oems_settings.oems', explode(',', $this->groupCode));
    // }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->products()->delete(); // Delete associated product mappings
            $category->images()->delete();   // Delete associated image mappings

           if ($category->images->isNotEmpty()) {
            foreach ($category->images as $image) {
                Storage::delete($image->image_path);
            }
         }
           $category->deleteChildCategories($category);
        });
    }

    public function deleteChildCategories($category)
    {
        foreach ($category->children as $child) {
            // Recursively delete child categories and their associated images and products
            $this->deleteChildCategories($child);

            // Delete associated product mappings for the child category
            $child->products()->detach();

            // Delete associated image mappings for the child category
            $child->images()->delete();

            if ($child->images->isNotEmpty()) {
                foreach ($child->images as $image) {
                    Storage::delete($image->image_path);
                }
            }

            // Finally, delete the child category itself
            $child->delete();
        }
    }
}
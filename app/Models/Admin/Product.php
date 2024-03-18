<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Product
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $oemCode
 * @property string $productBrand
 * @property string $slug
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property string|null $couponCode
 * @property string|null $SKU
 * @property string|null $seoTitle
 * @property string|null $seoKeywords
 * @property string|null $seoDescription
 * @property array|null $tags
 * @property int|null $productUnit
 * @property int|null $productMaxQuantity
 * @property float|null $stockPrice
 * @property float|null $mrp
 * @property float|null $basePrice
 * @property string $isActive
 * @property string $isCoupon
 * @property string $isVariable
 * @property string $isFeatured
 * @property string $isPopular
 * @property array|null $similarProducts
 * @property array|null $reviews
 * @property array|null $priceRange
 * @property string|null $videoType
 * @property string|null $videosrc
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Category> $categories
 * @property-read int|null $categories_count
 * @property-read mixed $variations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\ItemVariation> $itemvariation
 * @property-read int|null $itemvariation_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsCoupon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsPopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsVariable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMrp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductMaxQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereReviews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSKU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSimilarProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVideoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVideosrc($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;

     protected $casts = [
        'reviews' => 'array',
        'similarProducts' => 'array',
        'tags' => 'array',
        'priceRange' => 'array',
    ];

    protected $fillable = ['name', 'price','oemCode', 'productBrand', 'slug','shortDescription','longDescription', 'couponCode',
        'SKU','seoTitle','seoKeywords','seoDescription', 'tags', 'productUnit', 'productMaxQuantity', 'stockPrice',  'mrp', 'basePrice', 'isActive', 'isCoupon','isVariable','isFeatured','isPopular','similarProducts','reviews','priceRange', 'videoType','videosrc','isDeal','isBestInSeller','isBulkUpload','showEditor'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    protected static function booted()
    {
        static::deleting(function ($product) {
            $product->categories()->detach(); // Delete associated category mappings
            $product->images()->detach();     // Delete associated image mappings

            // Delete images from storage
              if ($product->images->isNotEmpty()) {
                // Delete associated images from storage
                foreach ($product->images as $image) {
                    Storage::delete($image->image_path);
                }
            }
        });
    }

    public function itemvariation()
    {
        return $this->hasMany(ItemVariation::class);
    }

    public function createVariations(array $variationsData)
    {
        $createdVariations = [];
        foreach ($variationsData as $key => $variationData) {
            $itemVariation = new ItemVariation([
                'product_id' => $this->id,
                'oemCode' => $this->oemCode,
                'itemVariationName' => $variationData['combinationName'],
                'variatioons' => json_encode($variationData),
            ]);
            $this->itemvariation()->save($itemVariation);
            $createdVariations[] = $itemVariation;
        }
        return $createdVariations;
    }

    public function updateVariations(array $variationsData)
    {
        $updatedVariations = [];
        foreach ($variationsData as $key => $variationData) {
            $itemVariation = ItemVariation::updateOrCreate(
                [
                    'product_id' => $this->id,
                    'oemCode' => $this->oemCode,
                    'itemVariationName' => $variationData['combinationName'],
                ],
                [
                    'variatioons' => json_encode($variationData),
                ]
            );
             $updatedVariations[] = $itemVariation;
        }        
        $variationNames = collect($variationsData)->pluck('combinationName');
        $this->itemvariation()->whereNotIn('itemVariationName', $variationNames)->delete();
        return $updatedVariations;
    }

    public function getVariationsAttribute()
    {
        $variations = json_decode($this->attributes['variatioons'], true);
        unset($variations['combinationName']); // Remove the combinationName field
        $variations['id'] = $this->attributes['id'];
        $variations['product_id'] = $this->attributes['product_id'];
        $variations['oemCode'] = $this->attributes['oemCode'];
        $variations['combinationName'] = $this->attributes['itemVariationName'];
        $variations['images'] = $this->images;

        return $variations;
    }
}

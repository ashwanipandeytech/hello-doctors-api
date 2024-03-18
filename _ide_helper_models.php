<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Admin{
/**
 * App\Models\Admin\AdminUser
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $oemCode
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Permission> $rolePermissions
 * @property-read int|null $role_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\Admin\AdminUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class AdminUser extends \Eloquent {}
}

namespace App\Models\Admin{
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
	class Category extends \Eloquent {}
}

namespace App\Models\Admin{
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
	class CategoryImage extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\EntityImage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EntityImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntityImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EntityImage query()
 * @mixin \Eloquent
 */
	class EntityImage extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\ImageValidator
 *
 * @property int $id
 * @property string $moduleName
 * @property string $fileName
 * @property string $type
 * @property int $height
 * @property int $width
 * @property int $size
 * @property string $checkTypeValidation
 * @property string $checkHeightValidation
 * @property string $checkWidthValidation
 * @property string $checkValidation
 * @property string $chekSizeValidation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereCheckHeightValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereCheckTypeValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereCheckValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereCheckWidthValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereChekSizeValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageValidator whereWidth($value)
 * @mixin \Eloquent
 */
	class ImageValidator extends \Eloquent {}
}

namespace App\Models\Admin{
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
	class ItemVariation extends \Eloquent {}
}

namespace App\Models\Admin{
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
	class ItemVariationImage extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\OemModule
 *
 * @property int $id
 * @property string $moduleCode
 * @property string $OemGroup
 * @property string $menuName
 * @property string $menuIcon
 * @property int $sequence
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\OemsSetting|null $oemSetting
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\OemSubModule> $submodule
 * @property-read int|null $submodule_count
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule query()
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereMenuIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereModuleCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereOemGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemModule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OemModule extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\OemSubModule
 *
 * @property int $id
 * @property string $moduleCode
 * @property string $menuName
 * @property string $route
 * @property string $defaultPrivilege
 * @property string $showGroup
 * @property string $showOem
 * @property string $showLanguage
 * @property int $sequence
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $permission_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule query()
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereDefaultPrivilege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereModuleCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereShowGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereShowLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereShowOem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemSubModule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OemSubModule extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\Oems
 *
 * @property int $id
 * @property string $oemCode
 * @property string $groupCode
 * @property string $name
 * @property string $website
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Oems newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Oems newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Oems query()
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereGroupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Oems whereWebsite($value)
 * @mixin \Eloquent
 */
	class Oems extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\OemsSetting
 *
 * @property int $id
 * @property string $oems
 * @property string $groupCode
 * @property string $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\OemModule|null $oemModule
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereGroupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereOems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OemsSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class OemsSetting extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\Permission
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $privilegeStateName
 * @property string|null $groupCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\OemSubModule> $submodules
 * @property-read int|null $submodules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\UserPermission> $userPermissions
 * @property-read int|null $user_permissions_count
 * @method static \Database\Factories\Admin\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGroupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePrivilegeStateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace App\Models\Admin{
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
	class Product extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\ProductCategory
 *
 * @property int $product_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image_path
 * @property string $name
 * @property string $image_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\Resourceattributes
 *
 * @property int $id
 * @property string $oemCode
 * @property string $attributeName
 * @property array $attributeFields
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereAttributeFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereAttributeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereOemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Resourceattributes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Resourceattributes extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\Role
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\AdminUser> $adminUsers
 * @property-read int|null $admin_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Database\Factories\Admin\RoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\Systemschema
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema query()
 * @mixin \Eloquent
 */
	class Systemschema extends \Eloquent {}
}

namespace App\Models\Admin{
/**
 * App\Models\Admin\UserPermission
 *
 * @property int $id
 * @property int $admin_user_id
 * @property int $permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereAdminUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class UserPermission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property-read \App\Models\Product|null $product
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @mixin \Eloquent
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
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
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
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
 * @property string|null $tags
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
 * @property mixed|null $similarProducts
 * @property string|null $reviews
 * @property mixed|null $priceRange
 * @property string|null $videoType
 * @property string|null $videosrc
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProductImage> $images
 * @property-read int|null $images_count
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductCategory
 *
 * @property int $product_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}


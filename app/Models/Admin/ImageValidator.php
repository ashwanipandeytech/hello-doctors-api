<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\imageValidatorData;

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
class ImageValidator extends Model
{
    use imageValidatorData;
    use HasFactory;
    protected $table = 'imagevalidation';
}

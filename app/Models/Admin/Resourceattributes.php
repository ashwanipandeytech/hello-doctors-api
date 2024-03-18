<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Resourceattributes extends Model
{
    use HasFactory;
    protected $table = 'resource_attributes';
    protected $casts = [
        'attributeFields' => 'array'
    ];
    protected $fillable = ['attributeName', 'attributeFields','oemCode','status'];
}

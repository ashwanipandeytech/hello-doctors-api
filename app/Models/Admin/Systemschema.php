<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Admin\Systemschema
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Systemschema query()
 * @mixin \Eloquent
 */
class Systemschema extends Model
{
    use HasFactory;
    protected $table = 'system_schemas';
    protected $casts = [
        'featureValue' => 'array'
    ];
    protected $fillable = ['featureField', 'featureValue','oemCode'];
}

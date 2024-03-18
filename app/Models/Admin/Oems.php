<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Oems extends Model
{
    use HasFactory;

   protected $table = 'oems';

    protected $fillable = ['oemCode','name','website','status']; // Fillable attributes for mass assignment

   
}

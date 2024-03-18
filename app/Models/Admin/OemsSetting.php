<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class OemsSetting extends Model
{
    use HasFactory;
    protected $table = 'oems_settings';

    protected $fillable = ['groupCode', 'oemCode','description','status'];

    public function oemModule()
    {
        return $this->belongsTo(OemModule::class, 'groupCode', 'oemGroup');
    }

}

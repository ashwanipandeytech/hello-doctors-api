<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class OemModule extends Model
{
    use HasFactory;
    protected $table = 'oem_module';

    public function submodule()
    {
        return $this->hasMany(OemSubModule::class, 'moduleCode', 'moduleCode');
    }

    public function oemSetting()
    {
        return $this->hasOne(OemsSetting::class, 'groupCode', 'oemGroup');
    }
}

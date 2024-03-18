<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class OemSubModule extends Model
{
    use HasFactory;
    protected $table = 'oem_submodule';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'oem_submodule_permissions', 'privilegeStateName', 'defaultPrivilege');
    }
}

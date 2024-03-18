<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Permission extends Model
{
    use HasFactory;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    public function submodules()
    {
        return $this->belongsToMany(OemSubmodule::class, 'oem_submodule_permissions', 'permission_id', 'moduleCode');
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class, 'permission_id', 'id');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Role updated successfully', 'data' => $role], 200);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }

    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'permissions' => 'required|array',
        ]);

        $role = Role::find($request->input('role_id'));
        $permissions = $request->input('permissions');

        $role->permissions()->sync($permissions);

        return response()->json(['message' => 'Permissions assigned to role successfully'], 200);
    }
}

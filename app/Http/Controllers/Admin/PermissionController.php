<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Permission created successfully', 'data' => $permission], 201);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Permission updated successfully', 'data' => $permission], 200);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json(['message' => 'Permission deleted successfully'], 200);
    }

    public function assignPermissionToUser($userId, $permissionId)
    {
        $user = AdminUser::find($userId);
        $permission = Permission::find($permissionId);

        if ($user && $permission) {
            $user->permissions()->attach($permission);
            return response()->json(['message' => 'Permission assigned successfully.']);
        } else {
            return response()->json(['error' => 'User or permission not found.'], 404);
        }
    }

    public function deassignPermissionFromUser($userId, $permissionId)
    {
        $user = AdminUser::find($userId);
        $permission = Permission::find($permissionId);

        if ($user && $permission) {
            $user->permissions()->detach($permission);
            return response()->json(['message' => 'Permission deassigned successfully.']);
        } else {
            return response()->json(['error' => 'User or permission not found.'], 404);
        }
}
}

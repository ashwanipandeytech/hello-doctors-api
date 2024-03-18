<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\AdminUser;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use Laravel\Sanctum\HasApiTokens; 
use App\Traits\httpResponses;
use App\Traits\OemsSettingTrait;
use App\Models\Admin\OemModule;
use App\Models\Admin\OemSubModule;

class AdminUserController extends Controller
{
    use httpResponses;
    use OemsSettingTrait;

    public function create(Request $request)
    {
        $request->merge(['email' => $request->input('username')]);
        $request->validate([
            'data.name' => 'required|string',
            'data.email' => 'required|email|unique:admin_users,email',
            'data.password' => 'required|min:8|confirmed',
        ]);

        $user = AdminUser::create([
            'name' => $request->input('data.name'),
            'email' => $request->input('data.email'),
            'password' => Hash::make($request->input('data.password')),
            'oemCode' => Hash::make($request->input('data.oemCode')),
        ]);
        $user->username = $user->email;
        $user->token = $user->createToken('admin-token')->plainTextToken;
        if($user){
            return $this->success($user,'Registration successful',200);
        }else{
            return $this->error('','Registration Failed',401);
        }
    }

    public function login(Request $request)
    {
        $request->merge(['email' => $request->input('data.username')]);
        $request->validate([
        'email' => 'required|email',
        'data.password' => 'required',
        ]);
        $username = $request->input('email');
        $password = $request->input('data.password');
        if (Auth::guard('admin')->attempt(['email' => $username, 'password' => $password])) {
            $user = Auth::guard('admin')->user();
            $token = $user->createToken('admin-token')->plainTextToken;
             // Get the user's roles along with the role details
          //  $rolesWithPermissions = $user->roles()->with('permissions')->get();
            $groupCode = $this->getOemsSettingByOemCode($user->oemCode)->groupCode;
            // $oemModules = OemModule::with(['submodule', 'oemSetting' => function ($query) use ($groupCode) {
            //             $query->whereIn('groupCode', [$groupCode]);
            //         }])->get();
            $userId = $user->id;    
            $moduleIdsWithPermissions = OemSubModule::join('permissions', 'oem_submodule.defaultPrivilege', '=', 'permissions.privilegeStateName')
            ->join('admin_user_permissions', function ($join) use ($userId) {
                $join->on('permissions.id', '=', 'admin_user_permissions.permission_id')
                    ->where('admin_user_permissions.admin_user_id', $userId);
            })
            ->select('oem_submodule.moduleCode')
            ->distinct()
            ->pluck('moduleCode');

            $oemModules = OemModule::whereIn('moduleCode', $moduleIdsWithPermissions)
                ->with(['submodule' => function ($query) use ($userId) {
                    $query->select('oem_submodule.*', 'permissions.privilegeStateName')
                        ->join('permissions', 'oem_submodule.defaultPrivilege', '=', 'permissions.privilegeStateName')
                        ->join('admin_user_permissions', 'permissions.id', '=', 'admin_user_permissions.permission_id')
                        ->where('admin_user_permissions.admin_user_id', $userId)
                        ->where('oem_submodule.status', 'Yes');
                }])
            ->get();
            $responseData = [
                'ID' => $user->id,
                'name' => $user->name,
                'username' => $user->email,
                'token' => $token,
                'oemCode'=>$user->oemCode,
                'groupCode'=> $groupCode,
                'moduleData' => $oemModules,
                'oemSettings' => $this->getOemDetails($user->oemCode),
            ];

        //     foreach ($rolesWithPermissions as $role) {
        //         $roleData = [
        //             'roleId' => $role->id,
        //             'roleName' => $role->name,
        //             'permissions' => $role->permissions
        //         ];

        //         $responseData['RolePermissions'][] = $roleData;
        // }

         return $this->success($responseData,'',200);
        }

        return $this->error('','Credentials do not match',401);
    }

    public function logout(Request $request)
    {
         if ($request->user('admin')) {
        // Check if the user has a valid access token
        $accessToken = $request->user('admin')->currentAccessToken();
        if ($accessToken) {
            // Delete the access token
            $accessToken->delete();
            return $this->success('','Logged out successfully',200);
        }
        return $this->error('','Credentials do not match',400);
    }

    }

    public function resetPassword(Request $request)
    {
        // Implement password reset logic here
    }

    public function index()
    {
        $users = AdminUser::all();
        return response()->json(['users' => $users]);
    }

    public function show(AdminUser $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, AdminUser $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin_users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }

    public function destroy(AdminUser $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Other methods for password reset and email verification as needed

    public function assignRoles(Request $request)
    {
        // Validate the request data
        $request->validate([
            'user_id' => 'required|integer|exists:admin_users,id',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        $user = AdminUser::find($request->input('user_id'));

        // Retrieve role and permission IDs from request data
        $roleIds = $request->input('roles', []);
        $permissionIds = $request->input('permissions', []);

        if ($user) {
            // Sync user's roles and permissions
            $user->roles()->sync($roleIds);
            $user->permissions()->sync($permissionIds);

            return response()->json(['message' => 'Roles and permissions assigned successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function listAdminUsersWithRolesAndPermissions()
    {
       $adminUsers = AdminUser::with('roles', 'rolePermissions', 'permissions')->get();
       return response()->json($adminUsers);
    }

    public function getUserPermissions()
    {
         try {
            $userId = Auth::id();
        
            $userPermissions = AdminUser::with('permissions')->find($userId);

            $privilegeStateNames = $userPermissions->permissions->pluck('privilegeStateName')
                ->map(function ($privilegeStateName) {
                    return ['privilegeStateName' => $privilegeStateName];
                });

            if ($privilegeStateNames) {
                return $this->success($privilegeStateNames,'',200);
            } else {                
                return $this->error('','Data Not Found',400);
            }
        } catch (\Exception $e) {
           return $this->error('','Bad Request',401);
        } 
        
       
    }
}

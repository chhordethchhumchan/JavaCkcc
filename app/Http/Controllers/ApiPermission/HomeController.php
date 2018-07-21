<?php

namespace App\Http\Controllers\ApiPermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Response;
class HomeController extends Controller
{
      /**
     * Attach role to the user
     *
     * @param Integer $userId
     * @param String $role
     * @return void
     */ 
    // role_user(userId,roleId)
    public function attachUserRole($userId, $role){
        $user = User::find($userId);
        $roleId = Role::where('name', $role)->first();
        $user->roles()->attach($roleId);
        return response()->json(['user' => $user], 200);
    }
   
    /**
     * Get the role of the user
     *
     * @param Integer $userId
     * @return role
     */
    public function getUserRole($userId){
        $user = User::find($userId);
        return $user->roles;
    }
    /**
     * Attach a permission to a role
     *
     * @param Request $request
     * @return permission
     */ 
    // Request from role and permisiion to store in permission_role table 
    
    public function attachPermission(Request $request){
        $params = $request->only('permission', 'role');
        $permission_name = $params['permission'];
        $role_name = $params['role'];
        $role = Role::where('name', $role_name)->first();
        $permission = Permission::where('name', $permission_name)->first();
        $role->attachPermission($permission);
        // $test = $role->permission;
        // return $this->response()->created();
        return response()->json(['Pemission role' => 'Created with permission role'], 200);
    }

    /**
     * Check if the user has the permission
     *
     * @param Integer $user_id
     * @return Json
     */
    public function checkPermission($user_id, $permission){
        $user = User::find($user_id);
        if($user->can($permission)) {
            return response()->json(['Can' => 'true']);
        } else {
            return response()->json(['Can' => 'false']);
        }
    }
}

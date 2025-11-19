<?php

namespace App\Traits;

use App\Models\User;

trait FormatUserTrait
{
    
    protected function formatUser(User $user){

        $roles = $user->getRoleNames()->values()->toArray();
        $permissions = $user->getAllPermissions()->pluck('name')->values()->toArray();

        $role =  count($roles) == 1 ?  $roles[0] : $roles;
        $permission =  count($permissions) == 1 ?  $permissions[0] : $permissions;


        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $role,
            'permission' => $permission,
            'roles' => $roles,
            'permissions' => $permissions,
        ];

    }

}

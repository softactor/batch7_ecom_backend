<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(CreateRequest $request) : JsonResponse {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if($request->has('role')){
            $user->assignRole($request->role);
        }

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password,
                'role'    => $user->getRoleNames()->first(),
                'permissions'    => $user->getAllPermissions()->pluck('name'),
            ]
        ]);
    }

    public function index() {
        
    }
    
    public function show($id) {
        
    }
    
    public function update(Request $request) {
        
    }

    public function delete($id) {
        
    }
}

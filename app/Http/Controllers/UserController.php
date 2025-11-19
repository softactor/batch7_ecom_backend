<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'user' => $this->formatUser($user)
        ]);
    }

    public function me(Request $request)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'message' => 'Unauthenticated'
            ]);
        }
        return response()->json([
            'user' => $this->formatUser($user)
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

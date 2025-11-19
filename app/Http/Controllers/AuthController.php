<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginOtpSendRequest;
use App\Http\Requests\LoginOtpVerifyRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function loginOtpSend(LoginOtpSendRequest $request): JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        $otp = rand(100000,999999);
        if(!$user){
            $user =User::create([
                'email' => $request->email,
                'otp' => $otp,
            ]);
            $user->assignRole('customer');
        }else{
            $user->update([
                'otp' => $otp,
            ]);
        }
            


        Mail::raw('Your OTP is '.$otp, function($message) use($request){
            $message->to($request->email)->subject('Login OTP');
        });

        return $this->success(null,'OTP sent successfully to your email');
    }

    public function login(LoginOtpVerifyRequest $request): JsonResponse
    {
        $user = User::where('email',$request->email)->where('otp',$request->otp)->first();
        if(!$user) return $this->error(['Invalid OTP'],400);

        $user->update([
            'otp' => null,
        ]);

        $accessToken = $user->createToken('authToken')->plainTextToken;

        

        return $this->success([
            'access_token' => $accessToken,
            'user' => $this->formatUser($user)
        ],'Login Success');
    }
}

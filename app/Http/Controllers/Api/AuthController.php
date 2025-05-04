<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\EmailVerification;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\confirm;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "phone_no" => "required|string|unique:users",
            "password" => "required|string|confirmed"
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string"
        ]);

        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("myToken")->plainTextToken;

                return response()->json(
                    [
                        "status" => true,
                        "message" => "Logged in successfully",
                        "token" => $token
                    ]
                );
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match"
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Email is invalid"
            ]);
        }
    }

    public function profile()
    {
        $userdata = request()->user();

        return response()->json([
            "status" => true,
            "message" => "profile data",
            "data" => $userdata
        ]);
    }


    public function logout()
    {
        Request()->user()->tokens()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }

    public function sendMail(){
        Mail::to(request()->user())->send(new EmailVerification(request()->user()));

        return response()->json([
           "message" => 'Email verification link sent on your email' 
        ]);
    }

    public function verify(){

        if(!request()->user()->email_verified_at){
            request()->user()->forceFill([
                'email_verified_at' => now()
            ])->save();
        }
        return response()->json(["message" =>"Email Verified"]);
    }

    public function sendResetLinkEmail(LinkEmailRequest $request)
    {
        $url = URL::temporarySignedRoute('password.reset', now()
            ->addMinutes(30), ['email' => $request->email]);
            
        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);

        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return response()->json([
            "message" => 'Reset password link sent to your email'
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "message" => 'User not found'
            ], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "message" => 'Password reset successfully'
        ], 200);
    }
}
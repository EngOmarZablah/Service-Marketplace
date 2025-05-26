<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = request()->user();
        $user->update($request->all());
        return response()->json(["message" => "updated successfully"], 200);
    }

    public function changePassword(Request $request)
    {
        $user = request()->user();
        $user->update($request->all());
        return response()->json(["message" => "Password Updated Successfully"], 200);
    }
}
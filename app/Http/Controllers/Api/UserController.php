<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json(['Users' => $users], 200);
    }

    public function updateStatus($id, Request $request)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        return response()->json([
            "message" => 'Account ' . ucfirst($user->status),
        ], 200);
    }

    public function CreateNewUser(Request $request){
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "phone_no" => "required|string|unique:users",
            'role' => 'required',
        ]);
        $user = User::create($request->all());
        return response()->json();
    }
}
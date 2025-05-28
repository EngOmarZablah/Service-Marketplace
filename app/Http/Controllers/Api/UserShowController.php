<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserShowController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum','CheckUserStatus']);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'user' => request()->user()
        ]);
    }
}
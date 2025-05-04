<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum','verified']);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            "message" => 'Dashboard'
        ]);
    }
}
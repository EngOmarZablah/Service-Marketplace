<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Custom_request;
use Illuminate\Http\Request;

class CustomRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $custom_requests = Custom_request::all();
        return response()->json([
            'custom_requests' => $custom_requests
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $custom_request = new Custom_request();
        $custom_request->create($request->all());
        return response()->json([
            "message" => 'Custom Request Created Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $custom_request = Custom_request::find($id);
        return response()->json([
            "Custom Request" => $custom_request
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $custom_request = Custom_request::find($id);
        $custom_request->update($request->all());
        return response()->json([
            "message" => 'Custom Request Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $custom_request = Custom_request::find($id);
        $custom_request->delete();
        return response()->json([
            "message" => 'Custom Request Deleted Successfully'
        ], 200);
    }
}
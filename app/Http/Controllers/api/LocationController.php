<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationDetailResource;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Locale;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();

        if($locations->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Data lokasi tidak ditemukan!",
                "data" => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data lokasi.',
            'data' => LocationResource::collection($locations)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $locationDetail = Location::where('id', $id)->with('placement_item.item', 'placement_item.user')->first();

        if(!$locationDetail){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan lokasi dengan ID tersebut!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan lokasi detail.',
            'data' => new LocationDetailResource($locationDetail),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

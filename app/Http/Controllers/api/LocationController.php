<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\Api\UpdateLocationRequest;
use App\Http\Resources\LocationDetailResource;
use App\Http\Resources\LocationResource;
use App\Models\Location;

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
                "message" => "Data lokasi masih kosong!",
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
    public function store(CreateLocationRequest $request)
    {
        try{
            Location::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan lokasi.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan lokasi!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $locationDetail = Location::with('inventories.item', 'inventories.user')->find($id);

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
    public function update(UpdateLocationRequest $request, string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $location = Location::find($id);

        if(!$location){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan lokasi dengan ID tersebut!',
            ], 404);
        }

        try {
            $location->fill($request->validated());
            $location->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil memperbarui lokasi.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui lokasi!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $location = Location::find($id);

        if(!$location){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan lokasi dengan ID tersebut!',
            ], 404);
        }

        try {
            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus lokasi.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus lokasi!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

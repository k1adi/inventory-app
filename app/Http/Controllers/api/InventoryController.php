<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryDetailResource;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $inventoryData = Inventory::with(['item', 'location', 'user'])->get();
        $inventoryData = Inventory::all();

        if($inventoryData->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Data inventori tidak ditemukan!",
                "data" => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data inventori.',
            'data' => InventoryResource::collection($inventoryData)
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
        $inventoryDetail = Inventory::where('id', $id)
                          ->with('item.category', 'location', 'user')
                          ->first();
        if(!$inventoryDetail) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan inventori dengan ID tersebut!',
                'data' => [],
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan inventori detail.',
            'data' => new InventoryDetailResource($inventoryDetail),
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

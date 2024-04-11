<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemDetailResource;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $itemData = Item::with(['category'])->get();
        $itemData = Item::all();

        if($itemData->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data item tidak ditemukan!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data item.',
            'data' => ItemResource::collection($itemData)
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
        $itemDetail = Item::where('id', $id)
                      ->with('category', 'placement_item.location')
                      ->first();

        if(!$itemDetail) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan item dengan ID tersebut!',
                'data' => [],
            ], 404);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan item detail.',
            'data' => new ItemDetailResource($itemDetail),
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

<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\Api\UpdateItemRequest;
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
                'message' => 'Data item masih kosong!',
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
    public function store(CreateItemRequest $request)
    {
        try{
            Item::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan item.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan item!',
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
        $itemDetail = Item::with('category', 'inventories.location')->find($id);

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
    public function update(UpdateItemRequest $request, string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $item = Item::find($id);

        if(!$item){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan item dengan ID tersebut!',
            ], 404);
        }

        try {
            $item->fill($request->validated());
            $item->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil memperbarui item.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui item!',
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
        $item = Item::find($id);

        if(!$item){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan item dengan ID tersebut!',
            ], 404);
        }

        try {
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus item.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus item!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

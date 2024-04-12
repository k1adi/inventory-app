<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInventoryRequest;
use App\Http\Resources\InventoryDetailResource;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                "message" => "Data inventori masih kosong!",
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
    public function store(CreateInventoryRequest $request)
    {
        try{
            return $this->handleInventory($request->validated());
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan inventori!',
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
        $inventoryDetail = Inventory::with('item.category', 'location', 'user')->find($id);
        
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
    public function destroy(string $encryptId)
    {
        $id = MyHelper::decrypt_id($encryptId);
        $inventory = Inventory::find($id);

        if(!$inventory){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan inventori dengan ID tersebut!',
            ], 404);
        }

        try {
            $inventory->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus inventori.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus inventori!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function handleInventory($request){
        // Cek baris data pada table placement_item apakah memiliki item_id dan location_id yang sama
        $inventory = Inventory::where('item_id', $request['item_id'])
                    ->where('location_id', $request['location_id'])
                    ->first();

        if ($inventory) {
            // qty pada kolom baris yang sama akan ditambah dengan request->qty
           return  $this->increaseQtyInventory($inventory, $request['qty']);
        }

        // tambah baris baru jika item_id dengan lokasi_id belum ada pada table
        return $this->createNewInventory($request);
    }

    public function increaseQtyInventory($inventory, $qty){
        try {
            $inventory->qty = $qty;
            $inventory->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan qty pada item dan lokasi yang tersebut.'
            ], 200);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createNewInventory($request){
        $userId = Auth::id();
        $userName = Auth::user()->name;
        $item = Item::find($request['item_id']);
        $location = Location::find($request['location_id']);
        
        try {
            Inventory::create([
                'item_id' => $request['item_id'],
                'item_code' => $item->code,
                'item_name' => $item->name,
                'location_id' => $request['location_id'],
                'location_name' => $location->name,
                'qty' => $request['qty'],
                'user_id' => $userId,
                'user_name' => $userName,
            ]);

            return response()->json([
                'success' =>  true,
                'message' => 'Berhasil menambahkan inventori.'
            ], 201);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}

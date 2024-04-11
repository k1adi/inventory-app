<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Item;
use App\Models\Location;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.inventory.index', [
            'inventories' => Inventory::with(['location'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.inventory.create', [
            'items' => Item::all(),
            'locations' => Location::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateInventoryRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Kirim request ke fungsi handleInventory agar kode lebih rapih
            $this->handleInventory($request);

            return Redirect::route('inventory.create')->with('status', 'inventory-success');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan catatan inventori. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        return view('pages.inventory.edit', [
            'inventory' => $inventory,
            'locations' => Location::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Kirim request beserta objek placementItem ke fungsi lain agar kode lebih rapih
            $this->updateInventory($request, $inventory);

            return Redirect::route('inventory.edit', $inventory->id)->with('status', 'inventory-updated');
        } catch (ValidationException $e) {
            // Tangkap pesan error pada validation exception
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangkap pesan error umum
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui catatan inventori. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        try {
            $inventory->delete();

            return Redirect::route('inventory.index');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return Redirect::back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus inventori. Silakan coba lagi.'])->withInput();
        }
    }

    public function handleInventory(Request $request)
    {
        // Cek baris data pada table placement_item apakah memiliki item_id dan location_id yang sama
        $invetory = Inventory::where('item_id', $request->item_id)
                    ->where('location_id', $request->location_id)
                    ->first();

        if ($invetory) {
            // qty pada kolom baris yang sama akan ditambah dengan request->qty
            $this->increaseQtyInventory($invetory, $request->qty);
        } else {
            // tambah baris baru jika item_id dengan lokasi_id belum ada pada table
            $this->createNewInventory($request);
        }
    }

    public function updateInventory(Request $request, $inventory)
    {   
        // Cek lokasi id yang sedang diubah
        if ($inventory->location_id == $request->location_id) {
            // Ubah nilai qty pada table jika lokasi_id tidak ikut diubah
            $this->updateQtyInventory($inventory, $request->qty);
        } else {
            // Validasi jumlah qty yang tersedia untuk lokasi baru
            $this->validateCreateInventoryQty($request);
        }
    }

    public function increaseQtyInventory($inventory, $qty)
    {
        $inventory->qty += $qty;
        $inventory->save();
    }

    public function createNewInventory($request)
    {
        $userId = Auth::id();
        $userName = Auth::user()->name;
        $item = Item::findOrFail($request->item_id);
        $location = Location::findOrFail($request->location_id);

        Inventory::create([
            'item_id' => $request->item_id,
            'item_code' => $item->code,
            'item_name' => $item->name,
            'location_id' => $request->location_id,
            'location_name' => $location->name,
            'qty' => $request->qty,
            'user_id' => $userId,
            'user_name' => $userName,
        ]);
    }

    public function updateQtyInventory($inventory, $qty)
    {
        $inventory->qty = $qty;
        $inventory->save();
    }

    public function validateCreateInventoryQty($request){
        $itemQty = Item::findOrFail($request->item_id)->qty;
        $inventoryQty = Inventory::where('item_id', $request->item_id)->sum('qty');
        $remainingQty = $itemQty - $inventoryQty;

        // Cek jika qty yang diinput tidak melebihi qty yang tersedia
        if($request->qty > $remainingQty) {
            throw ValidationException::withMessages([
                'qty' => ['Jumlah qty yang di-input melebihi qty yang tersedia. Qty tersisa: '.$remainingQty]
            ]);
        } else {
            // Jalankan fungsi tambah data baru pada table placement_item
            $this->createNewInventory($request);
        }
    }
}

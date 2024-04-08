<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlacementItemRequest;
use App\Http\Requests\UpdatePlacementItemRequest;
use App\Models\Item;
use App\Models\Location;
use App\Models\PlacementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PlacementItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.placement.index', [
            'placements' => PlacementItem::with(['location'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.placement.create', [
            'items' => Item::all(),
            'locations' => Location::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePlacementItemRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Kirim request ke fungsi handlePlacementItem agar kode lebih rapih
            $this->handlePlacementItem($request);

            return Redirect::route('placement_item.create')->with('status', 'placement-success');
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
    public function edit(PlacementItem $placementItem)
    {
        return view('pages.placement.edit', [
            'placementItem' => $placementItem,
            'locations' => Location::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlacementItemRequest $request, PlacementItem $placementItem)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Kirim request beserta objek placementItem ke fungsi lain agar kode lebih rapih
            $this->updatePlacementItem($request, $placementItem);

            return Redirect::route('placement_item.edit', $placementItem->id)->with('status', 'placement-updated');
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
    public function destroy(PlacementItem $placementItem)
    {
        try {
            $placementItem->delete();

            return Redirect::route('placement_item.index');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return Redirect::back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus inventori. Silakan coba lagi.'])->withInput();
        }
    }

    public function handlePlacementItem(Request $request)
    {
        // Cek baris data pada table placement_item apakah memiliki item_id dan location_id yang sama
        $placementItem = PlacementItem::where('item_id', $request->item_id)
                        ->where('location_id', $request->location_id)
                        ->first();

        if ($placementItem) {
            // qty pada kolom baris yang sama akan ditambah dengan request->qty
            $this->increaseQtyPlacementItem($placementItem, $request->qty);
        } else {
            // tambah baris baru jika item_id dengan lokasi_id belum ada pada table
            $this->createNewPlacementItem($request);
        }
    }

    public function updatePlacementItem(Request $request, $inventory)
    {   
        // Cek lokasi id yang sedang diubah
        if ($inventory->location_id == $request->location_id) {
            // Ubah nilai qty pada table jika lokasi_id tidak ikut diubah
            $this->updateQtyPlacementItem($inventory, $request->qty);
        } else {
            // Validasi jumlah qty yang tersedia untuk lokasi baru
            $this->validateCreatePlacementQty($request);
        }
    }

    public function increaseQtyPlacementItem($placementItem, $qty)
    {
        $placementItem->qty += $qty;
        $placementItem->save();
    }

    public function createNewPlacementItem($request)
    {
        $userId = Auth::id();
        $userName = Auth::user()->name;
        $item = Item::findOrFail($request->item_id);
        $location = Location::findOrFail($request->location_id);

        PlacementItem::create([
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

    public function updateQtyPlacementItem($placementItem, $qty)
    {
        $placementItem->qty = $qty;
        $placementItem->save();
    }

    public function validateCreatePlacementQty($request){
        $itemQty = Item::findOrFail($request->item_id)->qty;
        $placementQty = PlacementItem::where('item_id', $request->item_id)->sum('qty');
        $remainingQty = $itemQty - $placementQty;

        // Cek jika qty yang diinput tidak melebihi qty yang tersedia
        if($request->qty > $remainingQty) {
            throw ValidationException::withMessages([
                'qty' => ['Jumlah qty yang di-input melebihi qty yang tersedia. Qty tersisa: '.$remainingQty]
            ]);
        } else {
            // Jalankan fungsi tambah data baru pada table placement_item
            $this->createNewPlacementItem($request);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacementItemRequest;
use App\Models\Item;
use App\Models\Location;
use App\Models\PlacementItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;

class PlacementItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['placements'] = PlacementItem::with(['location'])->get();
        return view('pages.placement.index', $data);
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
    public function store(PlacementItemRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan kesalahan dan input sebelumnya
            return back()->withErrors($validator)->withInput();
        }

        try {
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
    public function edit(string $id)
    {
        //
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

    public function handlePlacementItem(Request $request){
        $placementItem = PlacementItem::where('item_id', $request->item_id)
                        ->where('location_id', $request->location_id)
                        ->first();

        if ($placementItem) {
            $this->updateQtyPlacementItem($placementItem, $request->qty);
        } else {
            $this->createNewPlacementItem($request);
        }
    }

    public function updateQtyPlacementItem($placementItem, $qty) {
        $placementItem->qty += $qty;
        $placementItem->save();
    }

    public function createNewPlacementItem($request) {
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
}
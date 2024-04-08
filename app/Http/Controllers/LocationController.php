<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Support\Facades\Redirect;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['locations'] = Location::all();
        return view('pages.location.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLocationRequest $request)
    {
        try {
            Location::create($request->validated());

            return Redirect::route('location.create')->with('status', 'location-added');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return Redirect::back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan lokasi. Silakan coba lagi.'])->withInput();
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
    public function edit(Location $location)
    {
        return view('pages.location.edit', [
            'location' => $location 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try {
            $location->fill($request->validated());
            $location->save();
    
            return Redirect::route('location.edit', $location->id)->with('status', 'location-updated');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return Redirect::back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui lokasi. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try {
            $location->delete();

            return Redirect::route('location.index');
        } catch (\Exception $e) {
            // Handle error dan kirim pesan error ke halaman sebelumnya
            return Redirect::back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus lokasi. Silakan coba lagi.'])->withInput();
        }
    }
}

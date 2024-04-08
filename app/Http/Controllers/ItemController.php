<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['items'] = Item::with(['category'])->get();
        return view('pages.item.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('pages.item.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateItemRequest $request)
    {        
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            // Validasi gagal, lakukan sesuatu seperti menangani pesan kesalahan
            // Anda juga bisa melakukan redirect kembali ke halaman sebelumnya dengan pesan kesalahan
            return back()->withErrors($validator)->withInput();
        }

        Item::create($request->validated());

        return Redirect::route('item.create')->with('status', 'item-added');
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
    public function edit(Item $item)
    {
        return view('pages.item.edit', [
            'item' => $item,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $validatedData = $request->validated();
        $item->fill($validatedData);
        $item->save();

        return Redirect::route('item.edit', $item->id)->with('status', 'item-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return Redirect::route('item.index');
    }
}

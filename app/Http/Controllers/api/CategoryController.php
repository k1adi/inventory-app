<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Http\Resources\CategoryDetailResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        if($category->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Data kategori masih kosong!",
                "data" => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan data kategori.',
            'data' => CategoryResource::collection($category)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        try{
            Category::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan kategori.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan kategori!',
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
        $categoryDetail = Category::with('items')->find($id);

        if(!$categoryDetail){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan kategori dengan ID tersebut!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendapatkan kategori detail.',
            'data' => new CategoryDetailResource($categoryDetail),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $decryptId = MyHelper::decrypt_id($id);
        $category = Category::find($decryptId);

        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan kategori dengan ID tersebut!',
            ], 404);
        }

        try {
            $category->fill($request->validated());
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil memperbarui kategori.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kategori!',
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
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menemukan kategori dengan ID tersebut!',
            ], 404);
        }

        try {
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus kategori.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus kategori!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

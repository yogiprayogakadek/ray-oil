<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function render()
    {
        $data = Kategori::all();

        $view = [
            'data' => view('admin.kategori.render', compact('data'))->render()
        ];

        return response()->json($view);
    }
    
    public function print()
    {
        $data = Kategori::all();

        $view = [
            'data' => view('admin.kategori.print', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function create()
    {
        $view = [
            'data' => view('admin.kategori.create')->render()
        ];

        return response()->json($view);
    }

    public function store(KategoriRequest $request)
    {
        try {
            Kategori::create([
                'nama' => $request->nama,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Kategori::find($id);
        $view = [
            'data' => view('admin.kategori.edit', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function update(KategoriRequest $request, Kategori $kategori)
    {
        try {
            $kategori = Kategori::find($request->id);
            $kategori->update([
                'nama' => $request->nama,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil tersimpan',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diubah',
                'title' => 'Gagal'
            ]);
        }
    }

    public function delete($id)
    {
        try {
            Kategori::find($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
                'title' => 'Gagal'
            ]);
        }
    }
}

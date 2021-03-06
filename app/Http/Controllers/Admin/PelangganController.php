<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return view('admin.pelanggan.index');
    }

    public function render()
    {
        $pelanggan = User::where('is_admin', false)->get();
        $view = [
            'data' => view('admin.pelanggan.render', compact('pelanggan'))->render()
        ];

        return response()->json($view);
    }

    public function delete($id)
    {
        try{
            $pelanggan = User::find($id);
            unlink($pelanggan->foto);
            $pelanggan->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus pelanggan',
                'title' => 'Berhasil'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus pelanggan',
                'title' => 'Gagal'
            ]);
        }
    }

    public function print()
    {
        $pelanggan = User::where('is_admin', false)->get();
        $view = [
            'data' => view('admin.pelanggan.print', compact('pelanggan'))->render()
        ];

        return response()->json($view);
    }
}

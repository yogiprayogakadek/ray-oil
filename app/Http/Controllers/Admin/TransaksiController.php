<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('admin.transaksi.index');
    }

    public function render($start, $end)
    {
        $data = Transaksi::with('user', 'detail_transaksi', 'pembayaran')->whereBetween('tanggal_transaksi', [$start, $end])->get();

        $view = [
            'data' => view('admin.transaksi.render', compact('data'))->render()
        ];

        return response()->json($view);
    }
    
    public function print($start, $end)
    {
        $data = Transaksi::with('user', 'detail_transaksi')->whereBetween('tanggal_transaksi', [$start, $end])->get();
        $view = [
            'data' => view('admin.transaksi.print', compact('data'))->render()
        ];

        return response()->json($view);
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with('user', 'detail_transaksi')->findOrFail($id);
        $data = array();
        foreach ($transaksi->detail_transaksi as $detail) {
            $data[] = [
                'nama' => $detail->produk->nama,
                'harga' => convertToRupiah($detail->produk->harga),
                'jumlah' => $detail->jumlah,
                'subtotal' => convertToRupiah($detail->produk->harga * $detail->jumlah)
            ];
        }
        return response()->json($data);
    }

    public function delete(Request $request)
    {
        try {
            $transaksi = Transaksi::find($request->id);
            $transaksi->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $transaksi = Transaksi::find($request->id_transaksi);
            $transaksi->status = $request->status;
            $transaksi->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diubah',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }
}

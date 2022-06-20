<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id_user;
        $transaksi = Transaksi::with('detail_transaksi')->where('id_user', $user_id)->get();
        $data = array();
        foreach($transaksi as $key => $value) {
            $data[] = [
                'no' => $key + 1,
                'id_transaksi' => $value->id_transaksi,
                'tanggal_transaksi' => $value->tanggal_transaksi,
                'total_harga' => convertToRupiah($value->total_harga),
                'origin' => Kota::where('id_kota', json_decode($value->alamat_pengiriman)[0]->origin)->first()->nama_kota,
                'destination' => Kota::where('id_kota', json_decode($value->alamat_pengiriman)[0]->destination)->first()->nama_kota,
                'ongkir' => convertToRupiah(json_decode($value->alamat_pengiriman)[0]->cost),
                'alamat' => json_decode($value->alamat_pengiriman)[0]->detail_alamat,
                'status' => $value->status,
            ];
        }
        // dd($data);
        return view('main.order.index', compact('data'));
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
                'subtotal' => convertToRupiah($detail->produk->harga * $detail->jumlah),
            ];
        }
        return response()->json($data);
    }
}

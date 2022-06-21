<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id_user;
        $transaksi = Transaksi::with('pembayaran')->where('id_user', $user_id)->get();
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
                'pembayaran' => $value->pembayaran->bukti_bayar ?? '-',
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

    public function unggahBukti(Request $request)
    {
        try {
            // dd($request->all());
            $transaksi = Transaksi::findOrFail($request->id_transaksi);
            if($request->hasFile('bukti_pembayaran')) {
                $filenamewithextension = $request->file('bukti_pembayaran')->getClientOriginalName();

                //get file extension
                $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();

                //filename to store
                $filenametostore = $request->nama . '-' . time() . '.' . $extension;
                $save_path = 'assets/uploads/media/bukti_pembayaran';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('bukti_pembayaran')->move($save_path, $filenametostore);

                $transaksi->update([
                    'status' => 'Menunggu Konfirmasi Pembayaran',
                ]);

                Pembayaran::updateOrCreate([
                    'id_transaksi' => $transaksi->id_transaksi,
                ], [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jumlah_bayar' => $transaksi->total_harga,
                    'status' => 'Menunggu Konfirmasi Pembayaran',
                    'tanggal_bayar' => date('Y-m-d'),
                    'metode_bayar' => 'Transfer Bank',
                    'bukti_bayar' => $save_path . '/' . $filenametostore,
                ]);

                // Pembayaran::create([
                //     'id_transaksi' => $transaksi->id_transaksi,
                //     'jumlah_bayar' => $transaksi->total_harga,
                //     'status' => 'Menunggu Konfirmasi Pembayaran',
                //     'tanggal_bayar' => date('Y-m-d'),
                //     'metode_bayar' => 'Transfer Bank',
                //     'bukti_bayar' => $save_path . '/' . $filenametostore,
                // ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Bukti Pembayaran Berhasil Diunggah',
                    'title' => 'Berhasil',
                ]);
            } else {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Mohon unggah bukti pembayaran',
                    'title' => 'Info',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Data gagal tersimpan',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use App\Models\Pembayaran;
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

    public function updateStatus(Request $request)
    {
        $transaksi = Transaksi::find($request->id_transaksi);
        $pembayaran = Pembayaran::where('id_transaksi',$transaksi->id_transaksi)->first();

        try {
            // dd($request->all());
            if($request->has('status_pembayaran')) {
                if($pembayaran->status == 'Pembayaran Diterima') {
                    // dd(1);
                    if($request->status_pembayaran != 'Pembayaran Diterima') {
                        $transaksi->update([
                            'status' => $request->status_transaksi
                        ]);
                        $pembayaran->update([
                            'status' => $request->status_pembayaran
                        ]);
                    }
                }
            }

            if(in_array($transaksi->status, ['Transaksi Diterima', 'Transaksi Ditolak'])) {
                // dd(2);
                $transaksi->update([
                    'status' => $request->status_transaksi
                ]);
                $pembayaran->update([
                    'status' => $request->status_pembayaran
                ]);
            } else {
                if($request->status_transaksi == 'Menunggu Konfirmasi Pembayaran') {
                    // dd(3);
                    $transaksi->update([
                        'status' => $request->status_transaksi
                    ]);
                    $pembayaran->update([
                        'status' => 'Menunggu Konfirmasi Pembayaran'
                    ]);
                } else {
                    // dd($request->all());
                    $transaksi->update([
                        'status' => $request->status_transaksi
                    ]);
                    $pembayaran->update([
                        'status' => $request->status_pembayaran
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Status transaksi berhasil diubah',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }

        return response()->json(['success' => true]);
    }
    
    public function print($start, $end)
    {
        $transaksi = Transaksi::with('user', 'detail_transaksi')->whereBetween('tanggal_transaksi', [$start, $end])->get();
        $view = [
            'data' => view('admin.transaksi.print', compact('transaksi'))->render()
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
        return response()->json([
            'detail' => $data,
            'transaksi' => [
                'origin' => Kota::where('id_kota', json_decode($transaksi->alamat_pengiriman)[0]->origin)->first()->nama_kota,
                'destination' => Kota::where('id_kota', json_decode($transaksi->alamat_pengiriman)[0]->destination)->first()->nama_kota,
                'ongkir' => convertToRupiah(json_decode($transaksi->alamat_pengiriman)[0]->cost),
                'alamat' => json_decode($transaksi->alamat_pengiriman)[0]->detail_alamat,
                'status' => $transaksi->status,
                'tanggal' => $transaksi->tanggal_transaksi,
            ]
        ]);
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

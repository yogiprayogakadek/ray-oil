<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Kota;
use App\Models\Pembayaran;
use App\Models\Produk;
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
                    // dd(0);
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
                // dd(1);
                $original_status = $transaksi->getOriginal('status');
                // dd($original_status);
                $new = $transaksi->update([
                    'status' => $request->status_transaksi
                ]);
                $pembayaran->update([
                    'status' => $request->status_pembayaran
                ]);

                if($original_status == 'Transaksi Diterima') {
                    // dd($new->status);
                    if($new->status != 'Transaksi Diterima') {
                        $transaksi = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->get();
                        foreach($transaksi as $t) {
                            $produk = Produk::find($t->id_produk);
                            $produk->update([
                                'stok' => $produk->stok + $t->jumlah
                            ]);
                        }
                    }
                }
            } else {
                $original_status = $transaksi->getOriginal('status');
                // dd($original_status);
                if($request->status_transaksi == 'Menunggu Konfirmasi Pembayaran') {
                    // $transaksi->update([
                    //     'status' => $request->status_transaksi
                    // ]);
                    // $pembayaran->update([
                    //     'status' => 'Menunggu Konfirmasi Pembayaran'
                    // ]);

                    if($original_status == 'Transaksi Diterima') {
                        // dd('3');
                        // if($original_status != 'Transaksi Diterima') {
                            $dd = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->get();
                            foreach($dd as $t) {
                                $produk = Produk::find($t->id_produk);
                                $produk->update([
                                    'stok' => $produk->stok + $t->jumlah
                                ]);
                            }
                        // }
                    }
                } else {
                    // dd($request->all());
                    $transaksi->update([
                        'status' => $request->status_transaksi
                    ]);
                    $pembayaran->update([
                        'status' => $request->status_pembayaran
                    ]);

                    if(Transaksi::find($request->id_transaksi)->status == 'Transaksi Diterima') {
                        // dd(Transaksi::find($request->id_transaksi)->status);
                        $transaksi = DetailTransaksi::where('id_transaksi', $transaksi->id_transaksi)->get();
                        foreach ($transaksi as $t) {
                            $produk = Produk::find($t->id_produk);
                            // dd($produk);
                            $produk->update([
                                'stok' => $produk->stok - $t->jumlah
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Status transaksi berhasil diubah',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Status transaksi berhasil diubah',
                'title' => 'Berhasil'
            ]);
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage(),
            //     'title' => 'Gagal'
            // ]);
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

    // Proses Index
    // public function indexProses()
    // {
    //     return view('admin.transaksi.proses.index');
    // }

    // public function renderProses($start, $end)
    // {
    //     $data = Transaksi::with('user', 'detail_transaksi', 'pembayaran')->where('status', 'Transaksi Diterima')->whereBetween('tanggal_transaksi', [$start, $end])->get();

    //     $view = [
    //         'data' => view('admin.transaksi.proses.render', compact('data'))->render()
    //     ];

    //     return response()->json($view);
    // }

    // // Proses Belum Dibayar
    // public function indexBelumBayar()
    // {
    //     return view('admin.transaksi.belum-bayar.index');
    // }

    // public function renderBelumBayar($start, $end)
    // {
    //     $data = Transaksi::with('user', 'detail_transaksi', 'pembayaran')->where('status', 'Menunggu Konfirmasi Pembayaran')->whereBetween('tanggal_transaksi', [$start, $end])->get();

    //     $view = [
    //         'data' => view('admin.transaksi.belum-bayar.render', compact('data'))->render()
    //     ];

    //     return response()->json($view);
    // }
}

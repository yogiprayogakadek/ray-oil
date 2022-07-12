<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Kota;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Image;

class CartController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id_user;
        $cart = \Cart::session($user_id)->getContent();
        $produk = Produk::all();
        $dataProduk = [];

        $provinsi = Provinsi::pluck('nama_provinsi', 'id_provinsi')->prepend('Pilih Provinsi', '');

        foreach ($produk as $value) {
            $dataProduk += [
                $value->id_produk => [
                    'id_produk' => $value->id_produk,
                    'nama_produk' => $value->nama,
                    'harga' => $value->harga,
                ],
            ];
        }
        return view('main.cart.index', compact('cart', 'dataProduk', 'provinsi'));
    }

    public function add(Request $request)
    {
        $produk = Produk::find($request->id_produk);
        $user_id = auth()->user()->id_user;

        try {
            if($request->jumlah > $produk->stok) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Stok tidak mencukupi',
                    'title' => 'Info',
                ]);
            } else {
                if(\Cart::session($user_id)->get($produk->id_produk)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Produk sudah ada di keranjang',
                        'title' => 'Gagal',
                    ]);
                } else {
                    \Cart::session($user_id)->add([
                        'id' => $produk->id_produk,
                        'name' => $produk->nama,
                        'price' => $produk->harga,
                        'quantity' => $request->jumlah,
                        'associatedModel' => $produk,
                    ]);
    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Produk berhasil ditambahkan ke keranjang',
                        'title' => 'Berhasil',
                        // 'cart' => view('templates.partials.header-update')->render(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' =>$e->getMessage(),
                'title' => 'Gagal',
            ]);
        }
    }

    public function cart()
    {
        $user = auth()->user()->id_user;
        $cart = \Cart::session($user)->getContent();
        dd($cart);
    }

    public function removeCart($id)
    {
        $user = auth()->user()->id_user;
        \Cart::session($user)->remove($id);
        $cart = \Cart::session($user)->getContent();
        return response()->json([
            'data' => view('main.cart.update', compact('cart'))->render(),
            // 'cart' => view('templates.partials.header-update')->render(),
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'title' => 'Berhasil'
        ]);
    }

    public function updateCart(Request $request)
    {
        // dd($request->provinsi);
        $provinsi = Provinsi::pluck('nama_provinsi', 'id_provinsi')->prepend('Pilih Provinsi', '');
        $user_id = auth()->user()->id_user;
        $cart = \Cart::session($user_id)->getContent();
        $produkById = Produk::find($request->id_produk);
        $semuaProduk = Produk::all();
        $dataProduk = [];
        $total_harga = $request->total_harga;
        $id_provinsi = $request->provinsi;
        foreach ($semuaProduk as $value) {
            $dataProduk += [
                $value->id_produk => [
                    'id_produk' => $value->id_produk,
                    'nama_produk' => $value->nama,
                    'harga' => $value->harga,
                ],
            ];
        }
        \Cart::session($user_id)->update($request->id_produk, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty
            ],
        ]);

        return response()->json([
            'data' => view('main.cart.update', compact('cart', 'dataProduk', 'total_harga', 'provinsi', 'id_provinsi'))->render(),
            'status' => 'success',
            'message' => 'Produk berhasil diupdate',
            'title' => 'Berhasil',
            'id_provinsi' => $id_provinsi,
            'id_kota' => $request->kota,
            'alamat' => $request->alamat,
            // 'cart' => view('templates.partials.header-update')->render(),
        ]);

    }

    public function checkout(Request $request)
    {
        try {
            $data = \Cart::session(auth()->user()->id_user)->getContent();
            DB::transaction(function () use ($data, $request) {
                $pengiriman[] = [
                    'destination' => $request->destination,
                    'origin' => 32,
                    'weight' => $request->berat,
                    'courier' => 'jne',
                    'service' => 'reg',
                    'cost' => $request->ongkir,
                    'detail_alamat' => $request->alamat,
                ];
                $transaksi = Transaksi::create([
                    'id_user' => auth()->user()->id_user,
                    'total_harga' => $request->total_harga,
                    'tanggal_transaksi' => date('Y-m-d H:i:s'),
                    'status' => 'Menunggu Pembayaran',
                    'berat_barang' => $request->berat,
                    'alamat_pengiriman' => json_encode($pengiriman),
                ]);
                
                foreach ($data as $d) {
                    $produk = Produk::find($d->id);
                    $detail = DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_produk' => $d->id,
                        'jumlah' => $d->quantity,
                    ]);
                }

                \Cart::session(auth()->user()->id_user)->clear();
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil diproses',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Peminjaman gagal diproses',
                'message' => $e->getMessage(),
                'title' => 'Gagal'
            ]);
        }
    }

    public function city($province_id)
    {
        $kota = Kota::where('id_provinsi', $province_id)->pluck('nama_kota', 'id_kota');
        return response()->json($kota);
    }

    public function ongkir(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=32&destination=".$request->destination."&weight=".$request->weight."&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 2b5cd7a68882dcbc86b6b75da0af69a5"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $ongkir = json_decode($response);
            return response()->json($ongkir->rajaongkir->results[0]->costs[1]->cost[0]->value);
        }
    }
}

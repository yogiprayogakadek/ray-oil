<?php

use App\Models\DetailTransaksi;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function convertDate($date, $printDate = false)
{
    //explode / pecah tanggal berdasarkan tanda "-"
    $exp = explode("-", $date);

    $day = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $month = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    // return $exp[2] . ' ' . $month[(int)$exp[1]] . ' ' . $exp[0];

    $split       = explode('-', $date);
    $convertDate = $split[2] . ' ' . $month[(int)$split[1]] . ' ' . $split[0];

    if ($printDate) {
        $num = date('N', strtotime($date));
        return $day[$num] . ', ' . $convertDate;
    }
    return $convertDate;
}

function convertToRupiah($jumlah)
{
    return 'Rp' . number_format($jumlah, 0, '.', '.');
}

function fotoAkun()
{
    $foto = asset(auth()->user()->foto);
    return $foto;
}

function nama()
{
    $nama = auth()->user()->nama;
    return $nama;
}

function jabatan()
{
    return auth()->user()->is_admin == true ? 'Admin' : 'Customer';
}

function subtractingDate($date1, $date2)
{
    $datetime1 = strtotime($date1);
    $datetime2 = strtotime($date2);

    $secs = $datetime2 - $datetime1;// == <seconds between the two times>
    $days = $secs / 86400;
    return $days;
}

function subTotal()
{
    $user_id = auth()->user()->id_user;
    $cart = \Cart::session($user_id)->getContent();
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price * $item->quantity;
    }

    return convertToRupiah($subtotal);
}

function validSubTotal()
{
    $user_id = auth()->user()->id_user;
    $cart = \Cart::session($user_id)->getContent();
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price * $item->quantity;
    }

    return convertToRupiah($subtotal);
}

function validQuantity()
{
    $user_id = auth()->user()->id_user;
    $cart = \Cart::session($user_id)->getContent();
    $quantity = 0;
    foreach ($cart as $item) {
        $quantity += $item->quantity;
    }

    return $quantity;
}

function cartCount()
{
    $user_id = auth()->user()->id_user;
    // $cart = \Cart::session($user_id)->getContent()->count();
    $total = \Cart::session($user_id)->getTotalQuantity();

    return $total;
}

function cart()
{
    $user_id = auth()->user()->id_user;
    $cart = \Cart::session($user_id)->getContent();

    return $cart;
}

function strip_tags_content($string, $id)
{
    if (strlen($string) > 25) {
    $trimstring = substr($string, 0, 25). ' <br> <i class="btn-readmore" data-id='.$id.' style="cursor: pointer;">readmore...</i>';
    } else {
    $trimstring = $string;
    }

    return $trimstring;
}

function menu()
{
    $menu = [
        'Kategori', 'Produk', 'Tiket', 'Camping'
    ];

    return $menu;
}

function RouteURL()
{
    $url = [
        0 => 'admin.kategori.index',
        1 => 'admin.produk.index',
        2 => 'admin.transaksi.index',
        3 => 'admin.transaksi.index'
    ];

    return $url;
}

function totalProduk()
{
    $total = Produk::count();

    return $total;
}

function totalDetailPendapatan($model) {
    $kategori = Kategori::where('nama', $model)->first();
    $produk = Produk::where('id_kategori', $kategori->id_kategori)->first();
    $total = DetailTransaksi::where('id_produk', $produk->id_produk)->count();
    return $total;
}

function transaksiTotal($kategori)
{
    $data = Kategori::where('nama', $kategori)->first();
    $total = DB::table('detail_transaksi')
            ->select(DB::raw('SUM(detail_transaksi.jumlah) as total'))
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
            ->join('produk', 'detail_transaksi.id_produk', '=', 'produk.id_produk')
            ->where('produk.id_kategori', $data->id_kategori)
            ->groupBy('produk.id_kategori')
            ->get();

    return (int) filter_var($total[0]->total, FILTER_SANITIZE_NUMBER_INT);
}

function totalPendapatan($model)
{
    $a = 'App\Models\\' . $model;
    if($model == 'Tiket'){
        $total = transaksiTotal('Tiket');
    }
    elseif($model == 'Camping'){
        $total = transaksiTotal('Camping');
    }

    return $total;
}

function totalData($model)
{
    $a = 'App\Models\\' . $model;
    // if($model == 'Tiket'){
    //     $total = transaksiTotal('Tiket');
    // }
    // elseif($model == 'Camping'){
    //     $total = transaksiTotal('Camping');
    // }
    // else{
    // }
    $total = $a::count();
    return $total;
}

function bulan()
{
    $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    return $bulan;
}

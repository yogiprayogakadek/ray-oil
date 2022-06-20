<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function chart(Request $request)
    {
        $chart = array();
        $data = DB::table('produk')
                ->select('produk.id_produk', 'produk.nama', DB::raw('SUM(detail_transaksi.jumlah) as jumlah'))
                ->leftJoin('detail_transaksi', 'produk.id_produk', '=', 'detail_transaksi.id_produk')
                ->leftJoin('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
                ->whereMonth('transaksi.tanggal_transaksi', $request->bulan)
                ->whereYear('transaksi.tanggal_transaksi', $request->tahun)
                ->groupBy('produk.id_produk')
                ->get();

        foreach ($data as $key => $value) {
            $chart[] = [
                'nama_produk' => $value->nama,
                'jumlah' => $value->jumlah,
            ];
        }
        $view = [
            'data' => view('admin.dashboard.chart.index')->with([
                'bulan' => bulan()[$request->bulan-1],
                'tahun' => $request->tahun,
                'chart' => $chart,
                'totalData' => count($data),
            ])->render()
        ];

        return response()->json($view);
    }
}

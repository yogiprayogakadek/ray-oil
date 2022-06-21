@extends('templates.master')

@section('pwd', 'Laporan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row printableArea">
    <div class="col-md-12">
        <h3 style="text-align: center">
            <b>Laporan Data Pembayaran</b>
        </h3>
        <div class="pull-right text-end">
            <address>
                <p class="m-t-30">
                    <img src="{{asset('assets/images/logo-decor.png')}}" height="100">
                </p>
                <p class="m-t-30">
                    <b>Dicetak oleh :</b>
                    <i class="fa fa-user"></i> {{nama()}}
                </p>
                <p class="m-t-30">
                    <b>Tanggal Laporan :</b>
                    <i class="fa fa-calendar"></i> {{date('d-m-Y')}}
                </p>
            </address>
        </div>
    </div>
    <div class="col-md-12 mt-4">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-striped" id="tableData">
                    {{-- <thead> --}}
                        <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Status Penyewaan</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pengembalian</th>
                        <th>Subtotal</th>
                    </tr>
                    {{-- </thead> --}}
                    <tbody>
                        @foreach ($penyewaan as $penyewaan)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$penyewaan->user->nama}}</td>
                            <td>
                                {{$penyewaan->status == 1 ? 'Berhasil' : 'Menunggu'}}
                            </td>
                            <td>
                                {{$penyewaan->pembayaran->status == 1 ? 'Pembayaran Berhasil' : ($penyewaan->pembayaran->status == 2 ? 'Menunggu Pembayaran' : 'Pembayaran Ditolak')}}
                            </td>
                            <td>
                                {{$penyewaan->pengembalian->status == 1 ? 'Berhasil' : 'Menunggu Pengembalian'}}
                            </td>
                            <td>{{convertToRupiah($penyewaan->subtotal)}}</td>
                        </tr>
                        @endforeach
                    {{-- </tbody>
                    <tfoot> --}}
                        <tr>
                            <td colspan="5" class="text-end">
                                <b>Total</b>
                            </td>
                            <td>
                                <b>{{convertToRupiah($total)}}</b>
                            </td>
                        </tr>
                    {{-- </tfoot> --}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


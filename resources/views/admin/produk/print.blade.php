@extends('templates.master')

@section('pwd', 'Laporan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row printableArea">
    <div class="col-md-12">
        <h3 style="text-align: center">
            <b>Data Produk</b>
        </h3>
        <div class="pull-right text-end">
            <address>
                <p class="m-t-30">
                    {{-- <img src="{{asset('assets/images/logo/logo.png')}}" height="100"> --}}
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
                <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid"
                id="tableData">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        {{-- <th>Stok</th>
                        <th>Deskripsi</th> --}}
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->kategori->nama}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{convertToRupiah($data->harga)}}</td>
                        {{-- <td>{{$data->stok}}</td>
                        <td>{!!strip_tags_content($data->deskripsi, $data->id_produk)!!}</td> --}}
                        <td>
                            <img src="{{asset($data->foto)}}" height="100px">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection


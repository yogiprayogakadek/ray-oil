@extends('templates.master')

@section('pwd', 'Laporan')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row printableArea">
    <div class="col-md-12">
        <h3 style="text-align: center">
            <b>Data Pelanggan</b>
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
                <table class="table table-hover table-striped" id="tableData">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $pelanggan)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pelanggan->nama}}</td>
                            <td>{{$pelanggan->tempat_lahir}}</td>
                            <td>{{$pelanggan->tanggal_lahir}}</td>
                            <td>{{$pelanggan->jenis_kelamin}}</td>
                            <td>{{$pelanggan->alamat}}</td>
                            <td>
                                <img src="{{asset($pelanggan->foto)}}" class="img-rounded" width="100px">
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


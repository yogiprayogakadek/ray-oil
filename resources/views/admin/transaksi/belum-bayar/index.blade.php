@extends('templates.master')

@section('title', 'Menunggu Pembayaran')
@section('pwd', 'Rays Bali Oil')
@section('sub-pwd', 'Menunggu Pembayaran')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Transaksi</div>
                <div class="card-options">
                    <div class="form-group" style="margin-right: 2px">
                        <input type="date" class="form-control" id="start_date" value="{{date('Y-m-01')}}">
                    </div>
                    <div class="form-group" style="margin-right: 3px">
                        <input type="date" class="form-control" id="end_date" value="{{date("Y-m-t", strtotime(date('Y-m-01')))}}" min="{{date('Y-m-01')}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-lg" id="btn-search">
                            <i class="fe fe-refresh-cw"></i>
                        </button>
                        <button class="btn btn-success btn-lg btn-print">
                            <i class="fe fe-printer"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body render">

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('functions/transaksi/belum-bayar/main.js')}}"></script>
@endpush
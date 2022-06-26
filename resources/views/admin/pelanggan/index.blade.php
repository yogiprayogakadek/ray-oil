@extends('templates.master')

@section('title', 'Pelanggan')
@section('pwd', 'Rays Bali Oil')
@section('sub-pwd', 'Pelanggan')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="{{asset('functions/pelanggan/main.js')}}"></script>
@endpush
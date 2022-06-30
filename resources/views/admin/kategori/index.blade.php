@extends('templates.master')

@section('title', 'Kategori')
@section('pwd', 'Rays Bali Oil')
@section('sub-pwd', 'Kategori')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="{{asset('functions/kategori/main.js')}}"></script>
@endpush
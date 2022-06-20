@extends('templates.master')

@section('title', 'Kategori')
@section('pwd', 'Kategori')
@section('sub-pwd', 'Data')
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
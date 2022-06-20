@extends('templates.master')

@section('title', 'Produk')
@section('pwd', 'Produk')
@section('sub-pwd', 'Data')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="row render">
    {{--  --}}
</div>
@endsection

@push('script')
    <script src="https://spruko.com/demo/sash/sash/assets/plugins/select2/select2.full.min.js"></script>
    <script src="{{asset('functions/produk/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        function assets(url) {
            var url = '{{ url("") }}/' + url;
            return url;
        }

        $('body').on('click', '.btn-readmore', function (e) {
            let id = $(this).data('id');
            $('#modalReadmore').modal('show');
            $.get("/admin/produk/detail/"+id, function (data) {
                // console.log(data);
                // $('#modalReadmore #deskripsi').html(data);
                // $('#modalReadmore #deskripsi').html(
                //     $('<div/>', {
                //         html: data.deskripsi
                //     }).text()
                // );
                
                $('#modalReadmore #deskripsi').html(data.deskripsi)
            });
        })
    </script>
@endpush
@extends('templates.master')

@section('title', 'Pembelian')
@section('pwd', 'Banyu Wana Amerta')
@section('sub-pwd', 'Pembelian')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="card render">
    <div class="card-body ">
        <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid" id="tableData">
            <thead>
                <tr>
                    <th>No</th>
                    {{-- <th>Nama Pelanggan</th> --}}
                    <th>Tanggal Transaksi</th>
                    <th>Total Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    {{-- <td>{{$data->user->nama}}</td> --}}
                    <td>{{$data->tanggal_transaksi}}</td>
                    <td>{{convertToRupiah($data->total_harga)}}</td>
                    <td>
                        <button class="btn btn-primary btn-detail" data-id="{{$data->id_transaksi}}">
                            <i class="fa fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Transaksi</h5>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <table class="table table-stripped" id="tableDetail">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://spruko.com/demo/sash/sash/assets/plugins/select2/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2-show-search').select2({
            minimumResultsForSearch: '',
            width: '100%'
        });

        $('#tableData').DataTable({
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                lengthMenu: "Menampilkan _MENU_ data",
                search: "Cari:",
                emptyTable: "Tidak ada data tersedia",
                zeroRecords: "Tidak ada data yang cocok",
                loadingRecords: "Memuat data...",
                processing: "Memproses...",
                infoFiltered: "(difilter dari _MAX_ total data)"
            },
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
        });

        // detail
        $('body').on('click', '.btn-detail', function() {
                $('#tableDetail tbody').empty();
                let id = $(this).data('id')
                $.ajax({
                    type: "get",
                    url: "/order/detail/" + id,
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function (index, value) { 
                            var tr = '<tr>' +
                                        '<td>' + (index+1) + '</td>' +
                                        '<td>' + value.nama + '</td>' +
                                        '<td>' + value.harga + '</td>' +
                                        '<td>' + value.jumlah+ '</td>' +
                                        '<td>' + value.subtotal+ '</td>' +
                                    '</tr>';
                            $('#tableDetail tbody').append(tr);
                        });
                        $("#modalDetail").modal('show');
                    },
                    error: function (error) {
                        console.log("Error", error);
                    },
                });
            });
    });
</script>
@endpush
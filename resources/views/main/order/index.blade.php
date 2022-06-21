@extends('templates.master')

@section('title', 'Pembelian')
@section('pwd', 'Ray Oil')
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
                    <th>Tanggal Transaksi</th>
                    <th>Alamat Pengiriman</th>
                    <th>Total Transaksi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $data)
                <tr>
                    <td>{{$data['no']}}</td>
                    <td>{{$data['tanggal_transaksi']}}</td>
                    <td>
                        Asal : {{$data['origin']}}<br>
                        Tujuan : {{$data['destination']}}<br>
                        Detail : {{$data['alamat']}}
                    </td>
                    <td>{{$data['total_harga']}}</td>
                    <td>{{$data['status']}}</td>
                    <td>
                        @if ($data['pembayaran'] == '-')
                        <button class="btn btn-success btn-pembayaran" data-status="0" data-id="{{$data['id_transaksi']}}">
                            <i class="fa fa-money"></i> Unggah Bukti Pembayaran
                        </button>
                        @else
                        <button class="btn btn-success btn-pembayaran" data-status="1" data-image="{{$data['pembayaran']}}" data-id="{{$data['id_transaksi']}}">
                            <i class="fa fa-money"></i> Bukti Pembayaran
                        @endif
                        <button class="btn btn-primary btn-detail m-1" data-id="{{$data['id_transaksi']}}">
                            <i class="fa fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPembayaran" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran</h5>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form id="formPembayaran">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group image"></div>
                                <div class="form-group pembayaran-group">
                                    <input type="hidden" name="id_transaksi" id="id_transaksi">
                                    <label for="">Bukti Pembayaran</label>
                                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-save">Simpan</button>
                        <button type="button" class="btn btn-success btn-edit">Ubah Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal --}}
    
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

        // pembayaran
        $('body').on('click', '.btn-pembayaran', function() {
            let id = $(this).data('id')
            let status = $(this).data('status')
            $('#id_transaksi').val(id)
            if (status == '0') {
                $('.pembayaran-group').show()
                $('.btn-edit').hide()
            } else {
                $('.pembayaran-group').hide()
                $('.btn-save').hide()

                $('.image').html('<h4><strong>Bukti Pembayaran</strong></h4><br>' + '<img src="' + $(this).data('image') + '" style="width: 50%;">')
            }
            $('#modalPembayaran').modal('show');
        });

        // edit pembayaran
        $('body').on('click', '.btn-edit', function() {
            $('.pembayaran-group').show()
            $('.btn-save').show()
            $('.btn-edit').hide()
        });

        $('body').on('click', '.btn-save', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let form = $('#formPembayaran')[0]
            let data = new FormData(form)

            $.ajax({
                url: '/order/bukti-pembayaran',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    $('#modalPembayaran').modal('hide');
                    Swal.fire({
                        title: response.title,
                        text: response.message,
                        icon: response.status,
                    });

                    if (response.status == 'success') {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                    // location.reload();
                },
                error: function (error) {
                    console.log("Error", error);
                },
            });
        });
    });
</script>
@endpush
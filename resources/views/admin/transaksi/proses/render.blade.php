<table class="table table-hover table-striped" id="tableData">
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Subtotal</th>
        <th>Status Pembayaran</th>
        <th>Bukti</th>
        <th>Aksi</th>
    </thead>
    <tbody>
        @foreach ($data as $data)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$data->user->nama}}</td>
            <td>{{convertToRupiah($data->total_harga)}}</td>
            <td>
                <span class="badge bg-info">{{$data->pembayaran->status}}</span>
            </td>
            <td>
                <a style="margin-right: 2px" href="{{asset($data->pembayaran->bukti_bayar)}}" target="_blank" rel="noopener noreferrer">Lihat</a>
            </td>
            <td>
                <button class="btn btn-detail btn-info" style="margin-right: 2px" data-id="{{$data->id_transaksi}}"><i class="fa fa-eye" aria-hidden="true"></i> Detail</button>
                <button class="btn btn-edit btn-primary" style="margin-right: 2px" data-id="{{$data->id_transaksi}}" data-pembayaran="{{$data->pembayaran->status}}" data-transaksi="{{$data->status}}"><i class="fa fa-check-circle" aria-hidden="true"></i> Ubah</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Modal --}}
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-3">
                        <p><strong>Nama</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="nama"></p>
                    </div> --}}

                    <div class="col-md-3">
                        <p><strong>Asal</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="asal"></p>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Tujuan</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="tujuan"></p>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Alamat</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="alamat"></p>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Ongkir</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="ongkir"></p>
                    </div>

                    <div class="col-md-3">
                        <p><strong>Tanggal Transaksi</strong></p>
                    </div>
                    <div class="col-md-9">
                        <p id="tanggal"></p>
                    </div>
                </div>
                <table class="table table-hover" id="tableDetail">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal --}}

<!-- Modal -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
            </div>
            <form id="formTransaksi">
                <div class="modal-body">
                    <input type="hidden" name="id_transaksi" id="id_transaksi">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <label for="">Status Pembayaran</label>
                            </div>
                            <div class="col-4 mb-2">
                                <button type="button" class="btn btn-primary btn-update-status">
                                    Ubah Pembayaran
                                </button>
                            </div>
                        </div>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                            {{-- <option value="Menunggu Pembayaran">Menunggu Pembayaran</option> --}}
                            <option value="Menunggu Konfirmasi Pembayaran">Menunggu Konfirmasi Pembayaran</option>
                            <option value="Pembayaran Diterima">Pembayaran Diterima</option>
                            <option value="Pembayaran Ditolak">Pembayaran Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="form-grou">
                        <label for="">Status Transaksi</label>
                        <select name="status_transaksi" id="status_transaksi" class="form-control">
                            {{-- <option value="Menunggu Pembayaran">Menunggu Pembayaran</option> --}}
                            <option value="Menunggu Konfirmasi Pembayaran">Menunggu Konfirmasi Pembayaran</option>
                            <option value="Transaksi Diterima">Transaksi Diterima</option>
                            <option value="Produk Dikirim">Produk Dikirim</option>
                            <option value="Transaksi Selesai">Transaksi Selesai</option>
                            <option value="Transaksi Ditolak">Transaksi Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
</script>
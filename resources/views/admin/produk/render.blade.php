<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Data Produk</div>
            <div class="card-options">
                <button class="btn btn-primary btn-add">
                    <i class="fa fa-plus"></i> Tambah
                </button>
                <button class="btn btn-success btn-print" style="margin-left: 2px">
                    <i class="fa fa-print"></i> Cetak
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-nowrap border-bottom dataTable no-footer" role="grid"
                id="tableData">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Berat Produk</th>
                        <th>Harga</th>
                        {{-- <th>Deskripsi</th> --}}
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->kategori->nama}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{$data->berat_barang}} gram</td>
                        <td>{{convertToRupiah($data->harga)}}</td>
                        {{-- <td>{!!$data->deskripsi!!}</td> --}}
                        {{-- <td>{!!strip_tags_content($data->deskripsi, $data->id_produk)!!}</td> --}}
                        <td>
                            <img class="d-block w-100 br-5 image-update" alt="" src="{{asset($data->foto)}}"> 
                        </td>
                        <td>
                            <button class="btn btn-primary btn-edit" data-id="{{$data->id_produk}}">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-delete" data-id="{{$data->id_produk}}">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalReadmore" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Deskripsi Produk</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
            </div>
            <div class="modal-body">
                <div class="div-group">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea id="deskripsi" class="form-control" rows="10" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
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
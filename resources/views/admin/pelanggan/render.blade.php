<div class="card">
    <div class="card-header">
        <div class="card-title">Data Pelanggan</div>
        <div class="card-options">
            <button class="btn btn-success btn-print">
                <i class="fa fa-print"></i> Cetak
            </button>
        </div>
    </div>
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
                <th>Aksi</th>
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
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{$pelanggan->id_user}}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
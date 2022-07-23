<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Ubah Kategori</div>
            <div class="card-options">
                <button class="btn btn-info btn-data">
                    <i class="fa fa-eye"></i> Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="formEdit">
                <div class="form-group">
                    <input type="text" value="{{$data->id_kategori}}" name="id" hidden>
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama kategori" value="{{$data->nama}}">
                    <div class="invalid-feedback error-nama"></div>
                </div>
                <div class="form-group pull-right">
                    <button class="btn btn-danger btn-data" type="button">
                        <i class="fa fa-undo"></i> Batal
                    </button>
                    <button class="btn btn-success btn-update" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
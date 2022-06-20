<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Tambah Produk</div>
            <div class="card-options">
                <button class="btn btn-info btn-data">
                    <i class="fa fa-eye"></i> Data
                </button>
            </div>
        </div>
        <div class="card-body">
            <form id="formEdit">
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <input type="text" value="{{$data->id_produk}}" name="id" hidden>
                    <select name="id_kategori" id="id_kategori" class="form-control select2-show-search">
                        @foreach ($kategori as $key => $value)
                            <option value="{{$key}}" {{$key == $data->id_kategori ? 'selected' : ''}}>{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-id-kategori"></div>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control" name="nama" id="nama" placeholder="masukkan nama produk" value="{{$data->nama}}">
                    <div class="invalid-feedback error-nama"></div>
                </div>
                <div class="form-group">
                    <label for="berat">Berat Produk</label>
                    <input type="text" class="form-control" name="berat" id="berat" placeholder="masukkan berat produk" value="{{$data->berat_produk}}">
                    <span class="text-muted text-small">*berat produk dalam gram</span>
                    <div class="invalid-feedback error-berat"></div>
                </div>
                <div class="form-group">
                    <label for="harga">Harga Produk</label>
                    <input type="text" class="form-control" name="harga" id="harga" placeholder="masukkan harga produk" value="{{convertToRupiah($data->harga)}}">
                    <div class="invalid-feedback error-harga"></div>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Produk</label>
                    <input type="file" class="form-control" name="foto" id="foto" placeholder="masukkan foto" multiple="multiple">
                    <span class="text-muted text-small">*kosongkan jika tidak ingin mengubah foto</span>
                    <div class="invalid-feedback error-foto"></div>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Produk</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" placeholder="deskripsi produk">{{$data->deskripsi}}</textarea>
                    <div class="invalid-feedback error-deskripsi"></div>
                </div>
                <div class="form-group pull-right">
                    <button class="btn btn-success btn-update" type="button">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.select2-show-search').select2({
        minimumResultsForSearch: '',
        // width: '100%'
    });

    $('#deskripsi').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        popatmouseup: true,
    });
</script>

function getData() {
    $.ajax({
        type: "get",
        url: "/admin/produk/render",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

function tambah() {
    $.ajax({
        type: "get",
        url: "/admin/produk/create",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

var rupiah = $("#harga");
function convertToRupiah(number, prefix) {
    var number_string = number.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        remaining = split[0].length % 3,
        rupiah = split[0].substr(0, remaining),
        thousand = split[0].substr(remaining).match(/\d{3}/gi);

    if (thousand) {
        separator = remaining ? "." : "";
        rupiah += separator + thousand.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

$(document).ready(function () {
    getData();

    $("body").on("keyup", '#harga', function (e) {
        $("#harga").val(convertToRupiah($(this).val(), "Rp. "))
    });

    $('body').on('click', '.btn-add', function () {
        tambah();
    });

    $('body').on('click', '.btn-data', function () {
        getData();
    });

    $('body').on('click', '.btn-edit', function () {
        let id = $(this).data('id')
        $.ajax({
            type: "get",
            url: "/admin/produk/edit/" + id,
            dataType: "json",
            success: function (response) {
                $(".render").html(response.data);
            },
            error: function (error) {
                console.log("Error", error);
            },
        });
    });

    // on save button
    $('body').on('click', '.btn-save', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let form = $('#formAdd')[0]
        let data = new FormData(form)
        $.ajax({
            type: "POST",
            url: "/admin/produk/store",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $('.btn-save').attr('disable', 'disabled')
                $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function () {
                $('.btn-save').removeAttr('disable')
                $('.btn-save').html('Simpan')
            },
            success: function (response) {
                $('#formAdd').trigger('reset')
                $(".invalid-feedback").html('')
                getData();
                Swal.fire(
                    response.title,
                    response.message,
                    response.status
                );
            },
            error: function (error) {
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        if (error.responseJSON.errors.id_kategori) {
                            $('#id_kategori').addClass('is-invalid')
                            $('#id_kategori').trigger('focus')
                            $('.error-id-kategori').html(error.responseJSON.errors.id_kategori)
                        } else {
                            $('#id_kategori').removeClass('is-invalid')
                            $('.error-id-kategori').html('')
                        }
                        if (error.responseJSON.errors.nama) {
                            $('#nama').addClass('is-invalid')
                            $('#nama').trigger('focus')
                            $('.error-nama').html(error.responseJSON.errors.nama)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('.error-nama').html('')
                        }
                        if (error.responseJSON.errors.berat) {
                            $('#berat').addClass('is-invalid')
                            $('#berat').trigger('focus')
                            $('.error-berat').html(error.responseJSON.errors.berat)
                        } else {
                            $('#berat').removeClass('is-invalid')
                            $('.error-berat').html('')
                        }
                        if (error.responseJSON.errors.harga) {
                            $('#harga').addClass('is-invalid')
                            $('#harga').trigger('focus')
                            $('.error-harga').html(error.responseJSON.errors.harga)
                        } else {
                            $('#harga').removeClass('is-invalid')
                            $('.error-harga').html('')
                        }
                        if (error.responseJSON.errors.stok) {
                            $('#stok').addClass('is-invalid')
                            $('#stok').trigger('focus')
                            $('.error-stok').html(error.responseJSON.errors.stok)
                        } else {
                            $('#stok').removeClass('is-invalid')
                            $('.error-stok').html('')
                        }
                        if (error.responseJSON.errors.foto) {
                            $('#foto').addClass('is-invalid')
                            $('#foto').trigger('focus')
                            $('.error-foto').html(error.responseJSON.errors.foto)
                        } else {
                            $('#foto').removeClass('is-invalid')
                            $('.error-foto').html('')
                        }
                        if (error.responseJSON.errors.deskripsi) {
                            $('#deskripsi').addClass('is-invalid')
                            $('#deskripsi').trigger('focus')
                            $('.error-deskripsi').html(error.responseJSON.errors.deskripsi)
                        } else {
                            $('#deskripsi').removeClass('is-invalid')
                            $('.error-deskripsi').html('')
                        }
                    }
                }
            }
        });
    });

    // delete data
    $('body').on('click', '.btn-delete', function () {
        let id = $(this).data('id')
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "/admin/produk/delete/" + id,
                    dataType: "json",
                    success: function (response) {
                        $(".render").html(response.data);
                        getData();
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                    },
                    error: function (error) {
                        console.log("Error", error);
                    },
                });
            }
        })
    });

    // edit data
    // on save button
    $('body').on('click', '.btn-update', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let form = $('#formEdit')[0]
        let data = new FormData(form)
        $.ajax({
            type: "POST",
            url: "/admin/produk/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $('.btn-update').attr('disable', 'disabled')
                $('.btn-update').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function () {
                $('.btn-update').removeAttr('disable')
                $('.btn-update').html('Simpan')
            },
            success: function (response) {
                $('#formAdd').trigger('reset')
                $(".invalid-feedback").html('')
                getData();
                Swal.fire(
                    response.title,
                    response.message,
                    response.status
                );
            },
            error: function (error) {
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        if (error.responseJSON.errors.id_kategori) {
                            $('#id_kategori').addClass('is-invalid')
                            $('#id_kategori').trigger('focus')
                            $('.error-id-kategori').html(error.responseJSON.errors.id_kategori)
                        } else {
                            $('#id_kategori').removeClass('is-invalid')
                            $('.error-id-kategori').html('')
                        }
                        if (error.responseJSON.errors.nama) {
                            $('#nama').addClass('is-invalid')
                            $('#nama').trigger('focus')
                            $('.error-nama').html(error.responseJSON.errors.nama)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('.error-nama').html('')
                        }
                        if (error.responseJSON.errors.berat) {
                            $('#berat').addClass('is-invalid')
                            $('#berat').trigger('focus')
                            $('.error-berat').html(error.responseJSON.errors.berat)
                        } else {
                            $('#berat').removeClass('is-invalid')
                            $('.error-berat').html('')
                        }
                        if (error.responseJSON.errors.harga) {
                            $('#harga').addClass('is-invalid')
                            $('#harga').trigger('focus')
                            $('.error-harga').html(error.responseJSON.errors.harga)
                        } else {
                            $('#harga').removeClass('is-invalid')
                            $('.error-harga').html('')
                        }
                        if (error.responseJSON.errors.stok) {
                            $('#stok').addClass('is-invalid')
                            $('#stok').trigger('focus')
                            $('.error-stok').html(error.responseJSON.errors.stok)
                        } else {
                            $('#stok').removeClass('is-invalid')
                            $('.error-stok').html('')
                        }
                        if (error.responseJSON.errors.deskripsi) {
                            $('#deskripsi').addClass('is-invalid')
                            $('#deskripsi').trigger('focus')
                            $('.error-deskripsi').html(error.responseJSON.errors.deskripsi)
                        } else {
                            $('#deskripsi').removeClass('is-invalid')
                            $('.error-deskripsi').html('')
                        }
                    }
                }
            }
        });
    });

    $('body').on('click', '.btn-print', function () {
        Swal.fire({
            title: 'Cetak data produk?',
            text: "Laporan akan dicetak",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, cetak!'
        }).then((result) => {
            if (result.value) {
                var mode = "iframe"; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close,
                    popTitle: 'LaporanDataProduk',
                };
                $.ajax({
                    type: "GET",
                    url: "/admin/produk/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title= 'Laporan - ' + new Date().toJSON().slice(0,10).replace(/-/g,'/')
                        $(response.data).find("div.printableArea").printArea(options);
                    }
                });
            }
        })
    });
});

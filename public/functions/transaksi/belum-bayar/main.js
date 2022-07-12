function getData(start, end) {
    $.ajax({
        type: "get",
        url: "/admin/transaksi/belum-bayar/render/"+start+"/"+end,
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

$(document).ready(function () {
    var date = new Date();
    var startDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-01';
    var endDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-31';
    $('#start_date').change(function(){
        $('#end_date').attr('min', $(this).val());
        $('#end_date').val($(this).val());
    })
    getData(startDate, endDate);

    $('body #btn-search').click(function(){
        getData($('#start_date').val(), $('#end_date').val());
    })

    $('body').on('click', '.btn-update-status', function(){
        $('.btn-update-status').hide();
        $('#status_pembayaran').attr('readonly', false);
    });

    $('body').on('click', '.btn-edit', function() {
        let id = $(this).data('id');
        let pembayaran = $(this).data('pembayaran');
        let transaksi = $(this).data('transaksi');
        if(pembayaran == 'Pembayaran Diterima'){
            $('.btn-update-status').show();
            $('#status_pembayaran').attr('readonly', true);
        } else {
            $('.btn-update-status').hide();
            $('#modalUpdate').find('#status_transaksi').attr('readonly', true);
        }
        $('#modalUpdate').find('#id_transaksi').val(id);
        $('#modalUpdate').find('#status_pembayaran').val(pembayaran);
        $('#modalUpdate').find('#status_transaksi').val(transaksi);

        $('#modalUpdate').modal('show');
    });

    $('body').on('change', '#status_pembayaran', function() {
        let status = $(this).val();

        if(status == 'Pembayaran Diterima'){
            $('#status_transaksi').val('Transaksi Diterima');
        } else if(status == 'Pembayaran Ditolak'){
            $('#status_transaksi').val('Transaksi Ditolak');
        } else {
            $('#status_transaksi').val('Menunggu Konfirmasi Pembayaran');
        }
    });

    $('body').on('click', '.btn-save', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let form = $('#formTransaksi')[0]
        let data = new FormData(form)

        $.ajax({
            type: "POST",
            url: "/admin/transaksi/change-status-pembayaran",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                Swal.fire({
                    title: response.title,
                    text: response.message,
                    icon: response.status,
                });
                $('#modalUpdate').modal('hide');
                getData($('#start_date').val(), $('#end_date').val());
            },
            error: function (error) {
                console.log("Error", error);
            }
        });
    }); 

    $('body').on('click', '.btn-detail', function() {
        let id = $(this).data('id');
        $('#modalDetail').modal('show');
        $.get('/admin/transaksi/detail/'+id, function(response){
            $('#modalDetail').find('#asal').html(response.transaksi.origin);
            $('#modalDetail').find('#tujuan').html(response.transaksi.destination);
            $('#modalDetail').find('#alamat').html(response.transaksi.alamat);
            $('#modalDetail').find('#tanggal').html(response.transaksi.tanggal);
            $('#modalDetail').find('#ongkir').html(response.transaksi.ongkir);
            $('#tableDetail tbody').empty();
            $.each(response.detail, function(key, value){
                console.log(value);
                var tr = '<tr>' +
                            '<td>'+(key+1)+'</td>' +
                            '<td>'+value.nama+'</td>' +
                            '<td>'+value.jumlah+'</td>' +
                            '<td>'+value.harga+'</td>' +
                            '<td>'+value.subtotal+'</td>' +
                        '</tr>';
                $('#tableDetail tbody').append(tr);
            });
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
                    url: "/admin/transaksi/delete/" + id,
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

    $('body').on('click', '.btn-print', function () {
        Swal.fire({
            title: 'Cetak data transaksi?',
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
                    popTitle: 'LaporanDataTransaksi',
                };
                $.ajax({
                    type: "GET",
                    url: "/admin/transaksi/belum-bayar/print/"+$('#start_date').val()+"/"+$('#end_date').val(),
                    dataType: "json",
                    success: function (response) {
                        document.title= 'Laporan - ' + new Date().toJSON().slice(0,10).replace(/-/g,'/')
                        $(response.data).find("div.printableArea").printArea(options);
                    }
                });
            }
        })
    });

    $('body').on('click', '.btn-update', function() {
        let id = $(this).data('id')
        let status = $(this).data('status')
        Swal.fire({
            title: 'Ubah data transaksi?',
            text: "Data transaksi akan diubah",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!',
            input: 'select',
            inputValue: status,
            inputOptions: {
                '0': 'Masih Proses',
                '1': 'Berhasil',
            },
            inputPlaceholder: 'Pilih status',
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value != '') {
                        resolve()
                    } else {
                        resolve('Pilih status terlebih dahulu!')
                    }
                })
            }
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                formData.append('status', result.value);
                formData.append('id_transaksi', id);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    type: "POST",
                    url: "/admin/transaksi/update/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $(".render").html(response.data);
                        getData(startDate, endDate);
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
    })
});
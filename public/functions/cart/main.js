$(document).ready(function () {
    $('body').on('click', '.add-to-cart', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Tambah ke keranjang?',
            text: "Tambahkan",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, tambahkan!',
            }).then((result) => {
                var formData = new FormData();
                formData.append('id_produk', $('input[name=id_produk]').val());
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/cart/add",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.status == 'success') {
                                $('.cart-render').empty();
                                $('.cart-render').html(response.cart);
                            }
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                            })
                        }
                    });
                }
            })
    });

    $('body').on('click', '.btn-remove', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/cart/remove/' + id,
                    type: 'GET',
                    success: function (result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        if (result.status == 'success') {
                            $('.render').empty();
                            $('.render').html(result.data);
                            $('.cart-render').empty();
                            $('.cart-render').html(result.cart);
                        }
                        // location.reload();
                    }
                });
            }
        })
    });

    $('body').on('click', '.btn-checkout', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Anda yakin? Unggah bukti pembayaran untuk melanjutkan',
            text: $('body').find('.invalid-product').length > 0 ? 'Beberapa produk tidak di proses karena stok tidak tersedia' : '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Unggah dan Pesan',
            cancelButtonText: 'Batal',
            input: 'file',
            onBeforeOpen: () => {
                $('.swal2-file').change(function(){
                    var reader = new FileReader();
                    reader.readAsDataURL(this.files[0]);
                })
            },
            inputAttributes: {
                'accept': 'image/*',
                'aria-label': 'Upload your profile picture'
            },
            inputValidator: (value) => {
                return !value && 'Anda belum mengunggah bukti pembayaran!'
            },
        }).then((file) => {
            if (file.value) {
                var formData = new FormData();
                var file = $('.swal2-file')[0].files[0];
                formData.append('bukti_pembayaran', file);
                formData.append('invalid_product', $('body').find('.invalid-product').length > 0 ? $('body').find('.invalid-product').length : 0);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: '/cart/checkout',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        if (result.status == 'success') {
                            let timerInterval
                            Swal.fire({
                                title: result.message,
                                html: 'Anda akan diarahkan ke halaman histori dalam <b></b> milliseconds.',
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading()
                                    const b = Swal.getHtmlContainer().querySelector('b')
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                willClose: () => {
                                    location.href = '/order';
                                    // clearInterval(timerInterval)
                                }
                            })
                        }
                        // location.reload();
                    },
                    error: function(error) {
                        Swal.fire({ type: 'error', title: 'Oops...', text: error.responseJSON.message })
                    }
                });
            }
        })
    });

    $('body').find('.invalid-product').length > 0 ? $('.alert-danger').show() : $('.alert-danger').hide();

    $('body').on('click', '.counter-plus', function() {
        var id = $(this).data('id');
        var qty = parseInt($(this).parent().find('.qty').val()) + 1;
        console.log(qty);
        var cat = 'plus';
        $.ajax({
            url: '/cart/update-cart',
            type: 'POST',
            data: {
                id_produk: id,
                qty: qty,
                cat: cat,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                Swal.fire(
                    result.title,
                    result.message,
                    result.status
                )
                if (result.status == 'success') {
                    $('body').find('.invalid-product').length > 0 ? $('.alert-danger').show() : $('.alert-danger').hide();
                    $('.render').empty();
                    $('.render').html(result.data);
                    $('.cart-render').empty();
                    $('.cart-render').html(result.cart);
                }
            }
        });

    });

    $('body').on('click', '.counter-minus', function() {
        var id = $(this).data('id');
        var qty = parseInt($(this).parent().find('.qty').val()) - 1;
        var cat = 'minus';

        $.ajax({
            url: '/cart/update-cart',
            type: 'POST',
            data: {
                id_produk: id,
                qty: qty,
                cat: cat,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                Swal.fire(
                    result.title,
                    result.message,
                    result.status
                )
                if (result.status == 'success') {
                    $('body').find('.invalid-product').length > 0 ? $('.alert-danger').show() : $('.alert-danger').hide();
                    $('.render').empty();
                    $('.render').html(result.data);
                    $('.cart-render').empty();
                    $('.cart-render').html(result.cart);
                }
            }
        });
    });
});
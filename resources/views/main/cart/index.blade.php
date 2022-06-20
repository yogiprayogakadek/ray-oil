@extends('main.templates.master')

@section('content')
<!-- START WHY CHOOSE US -->	
<section class="why_choose section-padding render">			
	<div class="container">	
        <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
            <div class="card cart">
                <div class="card-header">
                    <h3 class="card-title">Shopping Cart</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-vcenter">
                            <thead>
                                <tr class="border-top">
                                    <th>Product</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cart as $cart)
                                <tr>
                                    <td>
                                        <div class="text-center"> 
                                            <img src="{{ asset($cart->associatedModel['foto']) }}" class="text-center" style="width: 100px"> 
                                        </div>
                                    </td>
                                    <td>{{ $cart->name }}</td>
                                    <td class="fw-bold">{{convertToRupiah($cart->price)}}</td>
                                    <td>
                                        <div class="handle-counter" id="handleCounter4"> 
                                            <button type="button" class="btn btn-white lh-2 shadow-none {{$cart->quantity == 1 ? 'btn-remove' : 'counter-minus'}}" data-id="{{$cart->id}}"> 
                                                <i class="fa fa-minus text-muted"></i> 
                                            </button> 
                                            <input type="text" value="{{$cart->quantity}}" class="qty form-control-lg text-center" name="qty" readonly> 
                                            <button type="button" class="counter-plus btn btn-white lh-2 shadow-none" data-id="{{$cart->id}}"> 
                                                <i class="fa fa-plus text-muted"></i> 
                                            </button>
                                        </div>
                                    </td>
                                    <td>{{convertToRupiah($cart->price*$cart->quantity)}}</td>
                                    <td>
                                        <div class=" d-flex g-2">
                                            <button class="btn text-danger bg-danger-transparent btn-icon py-1 btn-remove" data-id="{{$cart->id}}"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h3>Keranjang Kosong</h3>
                                    </td>
                                </tr>
                                @endforelse 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4"></div>
            <div class="col-4"></div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Cart Totals</div>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table table-borderless text-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-start">Total Barang</td>
                                        <td class="text-end"><span class="fw-bold text-success">{{validQuantity()}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sub Total</td>
                                        <td class="text-end">
                                            <span class="fw-bold  ms-auto subtotal">{{validSubTotal()}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fs-18">Total Bill</td>
                                        <td class="text-end">
                                            <span class="ms-2 fw-bold fs-23 bill">{{validSubTotal()}}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-list"> 
                            <a href="{{route('main')}}" class="btn btn-primary">
                                <i class="fa fa-arrow-left me-1"></i>
                                Continue Shopping
                            </a> 
                            <button class="btn btn-success float-sm-end btn-checkout">
                                Check out
                                <i class="fa fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div><!-- END CONTAINER -->			
</section>
<!-- END WHY CHOOSE US -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
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

            $('body').on('click', '.counter-plus', function() {
                var id = $(this).data('id');
                var qty = parseInt($(this).parent().find('.qty').val()) + 1;
                // console.log(qty);
                var cat = 'plus';
                $.ajax({
                    url: '/cart/update-cart',
                    type: 'POST',
                    data: {
                        id_produk: id,
                        qty: qty,
                        cat: cat,
                        total_harga: $('body .bill').text().replace(/[^0-9]/g,''),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        if (result.status == 'success') {
                            $('.render').empty();
                            $('.render').html(result.data);
                            // $('.cart-render').empty();
                            // $('.cart-render').html(result.cart);
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
                        total_harga: $('body .bill').text().replace(/[^0-9]/g,''),
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
                            // $('.cart-render').empty();
                            // $('.cart-render').html(result.cart);
                        }
                    }
                });
            });

            $('body').on('click', '.btn-checkout', function() {
                Swal.fire({
                    title: 'Proses?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Pesan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        var formData = new FormData();
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                        formData.append('total_harga', $('body .bill').text().replace(/[^0-9]/g,''));
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
                            error: function() {
                                Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
@extends('main.templates.master')

@section('content')

<!-- START WHY CHOOSE US -->
<section id="why_choose" class="why_choose section-padding">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-12 col-12">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="single_choose mrb40">
							<i class="fa-solid fa-history"></i>
							<h3>History</h3>
							<p>Rays Bali Oil is product are made in Indonesia. 
								We choose the best quality and freshest virgin coconut to 
								purifying the fruit flesh to get the 100% natural coconut oil to 
								produce.
								</p>
						</div>
					</div>

					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="single_choose mrb40">
							<i class="fa-solid fa-tint"></i>
							<h3>Unique</h3>
							<p>Rays Bali Oil has significant differences as compare to others, 
								we use Indonesia local from grand grandma Bali recipes„ 
								Our product do not contain any Preservatives and Additives 
								during processing, all coconuts are particularly selected to 
								ensuring freshest and best quality
								</p>
						</div>
					</div>

					<div class="col-xl-6 col-lg-6 col-md-6 col-12">
						<div class="single_choose">
							<i class="fa-solid fa-puzzle-piece"></i>
							<h3>Location</h3>
							<p>Rays Bali Oil is located in Nongan Village, Karangasem-Bali. The distance from the center of Denpasar is about 48 Km</p>
						</div>
					</div>
				</div>
			</div><!-- END COL -->

			<div class="col-xl-6 col-lg-6 col-md-12 col-12">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-12 col-12">
						<img src="{{asset('assets/images/photos/ray_oil_55.jpg')}}" alt="Image" >
					</div>

					<div class="col-xl-6 col-lg-6 col-md-12 col-12">
						<img src="{{asset('assets/images/photos/ray_oil_48.jpg')}}" alt="Image" class="mt-30">
					</div>
				</div>
			</div><!-- END COL -->

		</div><!-- END ROW -->

	</div><!-- END CONTAINER -->
</section>
<!-- END WHY CHOOSE US -->

<section id="special_package" class="special_package section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12" data-aos="fade-up">
				<div class="section-title text-center">
					{{-- <h2>Popular Package</h2> --}}
					<p>Our Products</p>
				</div>
			</div><!-- END COL -->
		</div><!-- END ROW -->

		<div class="row text-left">
			@forelse ($data as $produk)
			<div class="col-xl-4 col-lg-6 col-12">
				<div class="single_package" data-id="{{$produk->id_produk}}" data-nama="{{$produk->nama}}" data-kategori="{{$produk->kategori->nama}}" data-harga="{{convertToRupiah($produk->harga)}}" data-deskripsi="{{$produk->deskripsi}}" data-stok="{{$produk->stok}}">
					<a href="javascript:void()">
						<div class="pack_image">
							<img src="{{asset($produk->foto)}}" class="img-fluid">
						</div>

						<div class="tour_text">
							<h5>{{$produk->nama}}</h5>
							<span class="pack_price">Price <br> <span>{{convertToRupiah($produk->harga)}}</span></span>
						</div>
					</a>
				</div><!-- END SINGLE PACKAGE -->
			</div><!-- END COL -->
			@empty
			<div class="col-12">
				<div class="alert alert-warning">
					<h5>No Data</h5>
				</div>
			</div>
			@endforelse
		</div><!-- END ROW -->
	</div><!-- END CONTAINER -->
</section>
<!-- END TOP DEALS -->

<!-- START GALLERY -->
<section id="gallery" class="our_gallery section-padding">
	<div class="container">
		<div class="row">
			<div class="col-md-12" data-aos="fade-up">
				<div class="section-title text-center">
					{{-- <h2>Tour Gallery</h2> --}}
					<p>Gallery</p>
				</div>
			</div><!-- END COL -->
		</div><!-- END ROW -->

		<div class="portfolio-grid">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-6 col-12 portfolio-item">
					<div class="single-gallery">
						<img src="{{asset('assets/images/photos/ray_oil_57.jpg')}}" alt="gallery Image">
						<a href="{{asset('assets/images/photos/ray_oil_57.jpg')}}" class="gallery_enlarge_icon"><i class="icofont-ui-zoom-in"></i></a>
					</div>
				</div><!-- End Col -->

				<div class="col-xl-4 col-lg-4 col-md-6 col-12 portfolio-item">
					<div class="single-gallery">
						<img src="{{asset('assets/images/photos/ray_oil_36.jpg')}}" alt="gallery Image">
						<a href="{{asset('assets/images/photos/ray_oil_36.jpg')}}" class="gallery_enlarge_icon"><i class="icofont-ui-zoom-in"></i></a>
					</div>
				</div><!-- End Col -->

				<div class="col-xl-4 col-lg-4 col-md-6 col-12 portfolio-item">
					<div class="single-gallery">
						<img src="{{asset('assets/images/photos/ray_oil_41.jpg')}}" alt="gallery Image">
						<a href="{{asset('assets/images/photos/ray_oil_41.jpg')}}" class="gallery_enlarge_icon"><i class="icofont-ui-zoom-in"></i></a>
					</div>
				</div><!-- End Col -->

				<div class="col-xl-6 col-lg-6 col-md-6 col-12 portfolio-item">
					<div class="single-gallery">
						<img src="{{asset('assets/images/photos/ray_oil_35.jpg')}}" alt="gallery Image">
						<a href="{{asset('assets/images/photos/ray_oil_35.jpg')}}" class="gallery_enlarge_icon"><i class="icofont-ui-zoom-in"></i></a>
					</div>
				</div><!-- End Col -->

				<div class="col-xl-6 col-lg-6 col-md-6 col-12 portfolio-item">
					<div class="single-gallery">
						<img src="{{asset('assets/images/photos/ray_oil_55.jpg')}}" alt="gallery Image">
						<a href="{{asset('assets/images/photos/ray_oil_55.jpg')}}" class="gallery_enlarge_icon"><i class="icofont-ui-zoom-in"></i></a>
					</div>
				</div><!-- End Col -->
			</div>
		</div><!-- END portfolio-grid -->
	</div>

</section>
<!-- END GALLERY -->
@endsection

@section('modal')
	{{-- MODAL --}}
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Detail Produk</h5>
				<button type="button" class="btn btn-primary btn-pesan">Pesan</button>
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-2"><strong>Nama</strong></div>
					<div class="col-10"><span id="nama"></span></div>

					<div class="col-2"><strong>Harga</strong></div>
					<div class="col-10"><span id="harga"></span></div>

					<div class="col-2"><strong>Stok</strong></div>
					<div class="col-10"><span id="stok"></span></div>

					<div class="col-2"><strong>Kategori</strong></div>
					<div class="col-10"><span id="kategori"></span></div>

					<div class="col-2"><strong>Deskripsi</strong></div>
					<div class="col-10"><span id="deskripsi"></span></div>
				</div>
				<div class="order" hidden>
					<hr class="m-t-3">
					<form action="formOrder">
						<div class="form-group">
							<input type="hidden" name="id_produk" id="id_produk">
							<label for="">Jumlah</label>
							<input type="text" class="form-control jumlah" name="jumlah" id="jumlah" value="1" min="1">
							<div class="invalid-feedback-error-jumlah"></div>
						</div>
						<div class="form-group">
							<label for="">Total</label>
							<input type="text" class="form-control total" name="total" id="total" value="0" readonly>
							<div class="invalid-feedback-error-total"></div>
						</div>
					</form>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				@if (Auth::check())
				@can('member')
				<button class="btn ripple btn-primary me-2 add-to-cart"><i
					class="fe fe-shopping-cart"> </i> Order</button>
				{{-- <button class="btn ripple btn-primary me-2 add-to-cart" data-id="{{$data['id_produk']}}"><i
					class="fe fe-shopping-cart"> </i> Order</button> --}}
				@endcan
				@else
				<button class="btn ripple btn-primary me-2 must-login" data-admin="false"><i
					class="fe fe-shopping-cart"> </i> Order</button>
				{{-- <button class="btn ripple btn-primary me-2 must-login" data-admin="false" data-id="{{$data['id_produk']}}"><i
					class="fe fe-shopping-cart"> </i> Order</button> --}}
				@endif
			</div>
		</div>
	</div>
</div>
{{-- end modal --}}
@endsection

@push('scripts')
<script>
	function convertToRupiah(angka) {
		var rupiah = '';
		var angkarev = angka.toString().split('').reverse().join('');
		for (var i = 0; i < angkarev.length; i++)
			if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
		return rupiah.split('', rupiah.length - 1).reverse().join('');
	}

    $(document).on('click', 'a[href^="#"]', function (e) {
        var id = $(this).attr('href')

        var $id = $(id)
        if ($id.length === 0) {
            return;
        }

        e.preventDefault();

        var pos = $id.offset().top - 80;

        $('body, html').animate({
            scrollTop: pos
        })
    })

	$('.single_package').click(function() {
		let id = $(this).attr('data-id');
		let nama = $(this).attr('data-nama');
		let harga = $(this).attr('data-harga');
		let kategori = $(this).attr('data-kategori');
		let deskripsi = $(this).attr('data-deskripsi');
		let stok = $(this).attr('data-stok');

		$('#modalDetail').find('.add-to-cart').attr('data-id', id);
		$('#modalDetail #id_produk').val(id);
		$('#modalDetail #nama').html(nama);
		$('#modalDetail #harga').html(harga);
		$('#modalDetail #kategori').html(kategori);
		$('#modalDetail #deskripsi').html(deskripsi);
		$('#modalDetail #stok').html(stok);

		$('#modalDetail #total').val(convertToRupiah($('#harga').text().replace(/[^0-9]/g, '')*1));
		$('.order').prop('hidden', true)
		$('.add-to-cart').prop('hidden', true)
		$('.must-login').prop('hidden', true)
		$('#modalDetail').modal('show');
	})

	$('#jumlah').on('keyup',function() {
		let jumlah = $(this).val();
		let harga = $('#harga').text().replace(/[^0-9]/g, '');
		let total = jumlah * harga;
		$('#total').val(convertToRupiah(total));
		// let stok = $('#stok').text();
		// if(jumlah > stok) {
		// 	$(this).val(stok);
		// 	$('#total').val(convertToRupiah(stok*harga));
		// } else {
		// 	$('#total').val(convertToRupiah(total));
		// }
	})

	$('#jumlah').on('change',function() {
		let jumlah = $(this).val();
		let stok = $('#stok').text();
		let harga = ($('#harga').text().replace(/[^0-9]/g, '')*1);
		let total = 1 * harga;
		if (jumlah < 1 || jumlah == '') {
			$('#jumlah').val(1);
			$('#total').val(convertToRupiah(total));
		}
		// else if (jumlah > stok) {
		// 	$('#jumlah').val(stok);
		// 	$('#total').val(convertToRupiah(total));
		// } else {
		// 	alert('as')
		// 	// $('#total').val(convertToRupiah(total));
		// }
	})

	$('.must-login').click(function(){
		var login = '{{Auth::check()}}';
		var admin = $(this).data('admin');
		if(login == '') {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Anda harus login terlebih dahulu!',
			})
		}
	});

	$('body').on('click', '.btn-pesan', function() {
		$('.order').prop('hidden', false)
		$('.add-to-cart').prop('hidden', false)
		$('.must-login').prop('hidden', false)
	})

	$('.add-to-cart').on('click', function() {
		let id = $('#id_produk').val();
		let jumlah = $('#jumlah').val();
		
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
				formData.append('jumlah', $('input[name=jumlah]').val());
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
								$('#modalDetail').modal('hide');
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
	})
</script>
@endpush

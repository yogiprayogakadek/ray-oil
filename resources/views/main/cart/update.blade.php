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
                                    <td>{{ $cart->name }} <br> ({{$cart->associatedModel['berat_barang']}} gram)</td>
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
            <div class="col-4 mb-2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tujuan Pengiriman</div>
                    </div>
                    <div class="card-body py-2">
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select class="form-control" id="provinsi">
                                @foreach ($provinsi as $key => $value)
                                <option value="{{$key}}" {{$key == $id_provinsi ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group city-group">
                            <label for="">Kota</label>
                            <select class="form-control" id="kota"></select>
                        </div>
                        <div class="form-group complete-address">
                            <label for="">Alamat Lengkap</label>
                            <textarea name="address" id="address" class="form-control" rows="10"></textarea>
                        </div>
                        {{-- <div class="form-group courier-group">
                            <label for="">Kurir</label>
                            <select class="form-control" id="courier">
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4"></div>
            <div class="col-4"></div>
            <div class="col-4 mb-2">
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
                                        <td class="text-start">Berat Barang</td>
                                        <td class="text-end"><span class="fw-bold text-success product-weight">{{productWeight()}} gram</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Sub Total</td>
                                        <td class="text-end">
                                            <span class="fw-bold  ms-auto subtotal">{{validSubTotal()}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start">Ongkos Kirim</td>
                                        <td class="text-end">
                                            <span class="fw-bold ms-auto ongkir">0</span>
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
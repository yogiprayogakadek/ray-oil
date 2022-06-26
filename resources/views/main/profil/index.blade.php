@extends('templates.master')

@section('title', 'Profil')
@section('pwd', 'Rays Bali Oil')
@section('sub-pwd', 'Profil')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

@if (session()->has('message'))
    <script>
        Swal.fire({
            text: '{{ session()->get('message') }}',
            icon: '{{ session()->get('status') }}',
            confirmButtonText: 'OK'
        })
    </script>
@endif

<div class="row render">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Perhatian!</strong>
            Kosongkan password dan foto jika tidak ingin mengubah data tersebut.
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ubah Pendaftaran</div>
                <div class="card-options">
                    <button class="btn btn-info btn-data">
                        <i class="fa fa-eye"></i> Data
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="formEdit" action="{{route('profil.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group wrap-input100">
                                {{-- <input type="hidden" value="{{$data->id_user}}" name="id"> --}}
                                <label for="nama">Nama</label>
                                <input type="text" class="input100 form-control ms-0 tempat-lahir" id="nama" name="nama"
                                    placeholder="nama" value="{{auth()->user()->nama}}">
                                <div class="invalid-feedback error-nama"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" class="input100 form-control ms-0" name="tempat_lahir" id="tempatLahir"
                                    placeholder="tempat lahir" value="{{auth()->user()->tempat_lahir}}">
                                <div class="invalid-feedback error-tempat-lahir"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="input100 form-control ms-0 tanggal-lahir" name="tanggal_lahir"
                                    id="tanggalLahir" placeholder="tanggal lahir"
                                    value="{{auth()->user()->tanggal_lahir}}">
                                <div class="invalid-feedback error-tanggal-lahir"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenisKelamin" class="input100 form-control ms-0 jenis-kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki" {{auth()->user()->jenis_kelamin == 'Laki-Laki' ? 'selected'
                                        : ''}}>Laki-Laki</option>
                                    <option value="Perempuan" {{auth()->user()->jenis_kelamin == 'Perempuan' ? 'selected'
                                        : ''}}>Perempuan</option>
                                </select>
                                <div class="invalid-feedback error-jenis-kelamin"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="input100 form-control ms-0 alamat" name="alamat" id="alamat"
                                    placeholder="alamat" value="{{auth()->user()->alamat}}">
                                <div class="invalid-feedback error-alamat"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">No. HP</label>
                                <input type="text" class="input100 form-control ms-0 telp" name="telp" id="telp"
                                    placeholder="no. hp" value="{{auth()->user()->telp}}">
                                <div class="invalid-feedback error-telp"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Foto</label>
                                <input type="file" class="input100 form-control ms-0 foto" name="foto" id="foto" placeholder="foto"> 
                                <div class="invalid-feedback error-foto"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group wrap-input100">
                                <label class="form-label">email</label>
                                <input type="text" class="input100 form-control ms-0 email" name="email" id="email"
                                    placeholder="email" value="{{auth()->user()->email}}" disabled>
                                <div class="invalid-feedback error-email"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Password Sekarang</label>
                                <input type="password" class="input100 form-control ms-0 current-password" name="current_password" id="currentPassword"
                                    placeholder="password">
                                <div class="invalid-feedback error-current-password"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Password</label>
                                <input type="password" class="input100 form-control ms-0 password" name="password" id="password"
                                    placeholder="password">
                                <div class="invalid-feedback error-password"></div>
                            </div>
                            <div class="form-group wrap-input100">
                                <label class="form-label">Re-Password</label>
                                <input type="password" class="input100 form-control ms-0 password-confirmation" name="password_confirmation"
                                    id="passwordConfirmation" placeholder="konfirmasi password">
                                <div class="invalid-feedback error-password-confirmation"></div>
                            </div>
                        </div>
                    </div>
    
                    <div class="form-group pull-right">
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\ProfilRequest') !!}
    {{-- <script src="{{asset('functions/pelanggan/main.js')}}"></script> --}}
@endpush
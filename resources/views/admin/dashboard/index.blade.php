@extends('templates.master')

@section('title', 'Dashboard')
@section('pwd', 'Dashboard')
@section('sub-pwd', 'Data')

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="alert alert-info">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>Hai!</strong>
            Selamat datang, {{nama()}}
        </div>
        <div class="row">
            @foreach (menu() as $key => $menu)
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Jumlah {{$menu == 'Tiket' ? $menu . ' Terjual' : ($menu == 'Camping' ? $menu . ' Terjual' : $menu)}}</h6>
                                @if (totalProduk() > 0) 
                                    @if ($menu == 'Tiket' || $menu == 'Camping')
                                    <h2 class="mb-0 number-font">{{totalDetailPendapatan('Tiket') > 0 ? totalPendapatan('Tiket') : (totalDetailPendapatan('Camping') > 0 ? totalPendapatan('Camping') : 0)}}</h2>
                                    @else
                                    <h2 class="mb-0 number-font">{{totalData($menu)}}</h2>
                                    @endif
                                @else
                                    <h2 class="mb-0 number-font">0</h2>
                                @endif
                            </div>
                        </div>
                        <a href="{{route(RouteUrl()[$key])}}">
                            <span class="text-muted fs-12">
                                <span class="text-secondary">
                                    <i class="fe fe-arrow-right-circle text-secondary"></i> Detail
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-header bg-info-transparent card-transparent">
                <h3 class="card-title text-info chart-title">Chart Penjualan Produk</h3>
                <div class="card-options">
                    <div class="form-group">
                        <select class="form-control" id="bulan">
                            <option value="">Pilih Bulan</option>
                            @foreach (bulan() as $key => $bulan)
                            <option value="{{$key+1}}">{{$bulan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-left: 4px">
                        <select class="form-control" id="tahun">
                            <option value="">Pilih Tahun</option>
                            @for($i = 2022; $i <= 2030; $i++) <option value="{{$i}}">{{$i}}</option>
                                @endfor
                        </select>
                    </div>
                    <div class="form-group" style="margin-left: 4px">
                        <button class="btn btn-primary btn-lg" id="btn-search">
                            <i class="fe fe-refresh-cw"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body render"></div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function(){
        function renderChart(bulan, tahun, type) {
            $('.render').empty()
            if(bulan == '' || tahun == ''){
                $('.render').html('<div class="text-center"><h4>Tidak ada data</h4></div>')
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf...',
                    text: 'Pilih Bulan dan Tahun terlebih dahulu!',
                });
            }else{
                $.ajax({
                    url: "{{route('admin.dashboard.chart')}}",
                    type: 'POST',
                    data: {
                        type: type,
                        bulan: bulan,
                        tahun: tahun,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data){
                        $('.render').html(data.data);
                        if(type == 'terlaris') {
                            $('.chart-terlaris').addClass('bg-primary-transparent text-primary')
                            $('.chart-penjualan').removeClass('bg-primary-transparent text-primary')
                        }
                    }
                });
            }
        }

        $('#btn-search').click(function(){
            $('.render').empty()
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            renderChart(bulan, tahun, 'terlaris');
        });

        $('.chart-penjualan').click(function(){
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            $('.chart-penjualan').addClass('bg-primary-transparent text-primary')
            $('.chart-terlaris').removeClass('bg-primary-transparent text-primary')
            renderChart(bulan, tahun, 'penjualan');
        });

        $('.chart-terlaris').click(function(){
            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            $('.chart-terlaris').addClass('bg-primary-transparent text-primary')
            $('.chart-penjualan').removeClass('bg-primary-transparent text-primary')
            renderChart(bulan, tahun, 'terlaris');
        });
    });
</script>
@endpush

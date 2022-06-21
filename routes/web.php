<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('templates.master');
// })->name('main');

Route::prefix('/')->namespace('Main')->group(function(){
    Route::get('/', 'MainController@index')->name('main');

    Route::get('/produk/{id}', 'MainController@produk')->name('produk.detail');

    Route::middleware('guest')->group(function(){
        Route::get('/login', 'MainController@login')->name('main.login');
        Route::post('/register-proses', 'MainController@register')->name('main.register');
    });
});

Route::middleware('auth')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::namespace('Admin')->name('admin.')->prefix('/admin')->group(function(){
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::post('/chart', 'DashboardController@chart')->name('dashboard.chart');

        Route::prefix('/pelanggan')->group(function(){
            Route::get('/', 'PelangganController@index')->name('pelanggan.index');
            Route::get('/render', 'PelangganController@render')->name('pelanggan.render');
            Route::get('/print', 'PelangganController@print')->name('pelanggan.print');
            Route::get('/detail/{id}', 'PelangganController@detail')->name('pelanggan.detail');
            Route::get('/delete/{id}', 'PelangganController@delete')->name('pelanggan.delete');
        });

        Route::prefix('/kategori')->group(function(){
            Route::get('/', 'KategoriController@index')->name('kategori.index');
            Route::get('/render', 'KategoriController@render')->name('kategori.render');
            Route::get('/print', 'KategoriController@print')->name('kategori.print');
            Route::get('/create', 'KategoriController@create')->name('kategori.create');
            Route::post('/store', 'KategoriController@store')->name('kategori.store');
            Route::get('/edit/{id}', 'KategoriController@edit')->name('kategori.edit');
            Route::post('/update', 'KategoriController@update')->name('kategori.update');
            Route::get('/delete/{id}', 'KategoriController@delete')->name('kategori.delete');
        });

        Route::prefix('/produk')->group(function(){
            Route::get('/', 'ProdukController@index')->name('produk.index');
            Route::get('/render', 'ProdukController@render')->name('produk.render');
            Route::get('/print', 'ProdukController@print')->name('produk.print');
            Route::get('/create', 'ProdukController@create')->name('produk.create');
            Route::post('/store', 'ProdukController@store')->name('produk.store');
            Route::get('/edit/{id}', 'ProdukController@edit')->name('produk.edit');
            Route::get('/detail/{id}', 'ProdukController@detail')->name('produk.detail');
            Route::post('/update', 'ProdukController@update')->name('produk.update');
            Route::post('/update-image', 'ProdukController@updateImage')->name('update.image');
            Route::get('/delete/{id}', 'ProdukController@delete')->name('produk.delete');
        });

        Route::prefix('/transaksi')->name('transaksi.')->group(function(){
            Route::get('/', 'TransaksiController@index')->name('index');
            Route::get('/render', 'TransaksiController@render')->name('render');
            Route::post('/change-status-pembayaran', 'TransaksiController@updateStatus')->name('status.pembayaran');
            Route::get('/print', 'TransaksiController@print')->name('print');
            Route::get('/render/{start}/{end}', 'TransaksiController@render')->name('render');
            Route::get('/print/{start}/{end}', 'TransaksiController@print')->name('print');
            Route::get('/detail/{id}', 'TransaksiController@detail')->name('detail');
        });

        // Route::prefix('/transaksi')->name('transaksi.')->group(function() {
        //     Route::get('/', 'TransaksiController@index')->name('index');
        //     Route::post('/update', 'TransaksiController@update')->name('update');
        //     Route::get('/delete/{id}', 'TransaksiController@delete')->name('delete');
        // });
    });

    Route::namespace('Member')->name('member.')->group(function(){
        Route::prefix('/cart')->group(function(){
            Route::get('/', 'CartController@index')->name('cart.index');
            Route::post('/add', 'CartController@add')->name('cart.add');
            Route::get('/remove/{id}', 'CartController@removeCart')->name('cart.remove');
            Route::post('/checkout', 'CartController@checkout')->name('checkout');
            Route::post('/update-cart', 'CartController@updateCart')->name('cart.update');
            Route::get('/test', 'CartController@cart')->name('cart.test');
            Route::get('/city/{province_id}', 'CartController@city')->name('cart.city');
            Route::post('/ongkir', 'CartController@ongkir')->name('cart.ongkir');
        });

        Route::prefix('/order')->group(function(){
            Route::get('/', 'OrderController@index')->name('order.index');
            Route::get('/detail/{id}', 'OrderController@detail')->name('order.detail');
            Route::post('/bukti-pembayaran', 'OrderController@unggahBukti')->name('order.unggah');
        });
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

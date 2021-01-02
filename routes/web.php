<?php

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();
Route::prefix('admin')
    ->middleware(['admin'])
    ->group(function () {
        Route::get('/home', 'HomeController@handleAdmin')
            ->name('admin.route');
        Route::resource('produk', 'ProdukController');
        Route::resource('kategori', 'KategoriController');
        // Route::resource('transaksi', 'TransaksiController');
    });
Route::get('/', 'HomeController@index')->name('home');
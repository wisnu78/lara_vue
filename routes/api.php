<?php

use Illuminate\Http\Request;
use App\Barang;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Flutter
Route::get('flutter/banner','FlutterController@banner');
Route::get('flutter/banner/{img}','FlutterController@bannerImg');
Route::get('flutter/kategori','FlutterController@kategori');
Route::get('flutter/barang','FlutterController@barang');

Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');

    //Kategori
    Route::get('/kategori','KategoriController@index');
    Route::post('/kategori','KategoriController@store');
    Route::delete('/kategori/{id}','KategoriController@destroy');
    Route::put('/kategori/{id}','KategoriController@update');

    //Barang
    Route::get('/barang','BarangController@index');
    Route::post('/barang','BarangController@store');
    Route::delete('/barang/{id}','BarangController@destroy');
    Route::get('/barang/img/{img}','BarangController@getImg');

    // Kota
    
  });
  Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'AuthController@refresh');
  });
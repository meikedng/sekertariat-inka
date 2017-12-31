<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('sm_eksternal','SuratMasukEksternalController');

Route::get('/sm_eksternal/create_status/{tujuan_id}',[
    'as' => 'sme.create_status',
    'uses' => 'SuratMasukEksternalController@createStatus']);

Route::post('/sm_eksternal/store_status/{tujuan_id}',[
    'as' => 'sme.store_status',
    'uses' => 'SuratMasukEksternalController@storeStatus']);

Route::get('/sm_eksternal/create_disposisi/{tujuan_id}',[
    'as' => 'sme.create_disposisi',
    'uses' => 'SuratMasukEksternalController@createDisposisi']);

Route::post('/sm_eksternal/store_disposisi/{tujuan_id}',[
    'as' => 'sme.store_disposisi',
    'uses' => 'SuratMasukEksternalController@storeDisposisi']);
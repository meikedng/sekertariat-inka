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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('sm_eksternal','SuratMasukEksternalController');
Route::resource('sm_internal','SuratMasukInternalController');
Route::resource('memo_internal','MemoInternalController');
Route::resource('document_process','DokumenController');
Route::resource('monitoring_dokumen','MonitoringDokumenController');

Route::get('/monitoring/{route_doc}',[
    'as' => 'monitoring.show',
    'uses' => 'MonitoringDokumenController@showTipeDoc']);

Route::get('/monitoring/{route_doc}/disposisi',[
    'as' => 'monitoring.show_disposisi',
    'uses' => 'MonitoringDokumenController@showDisposisi']);

Route::get('/dokumen/{route_doc}/show/{tujuan_id}',[
    'as' => 'doc.show',
    'uses' => 'DokumenController@show']);

Route::get('/dokumen/{route_doc}/show_disposisi/{tujuan_id}',[
        'as' => 'doc.show_disposisi',
        'uses' => 'DokumenController@showDisposisi']);

Route::get('/dokumen/{route_doc}/create_status/{tujuan_id}',[
    'as' => 'doc.create_status',
    'uses' => 'DokumenController@createStatus']);

Route::post('/dokumen/{route_doc}/store_status/{tujuan_id}',[
    'as' => 'doc.store_status',
    'uses' => 'DokumenController@storeStatus']);

Route::get('/dokumen/{route_doc}/create_disposisi/{tujuan_id}',[
    'as' => 'doc.create_disposisi',
    'uses' => 'DokumenController@createDisposisi']);

Route::post('/dokumen/{route_doc}/store_disposisi/{tujuan_id}',[
    'as' => 'doc.store_disposisi',
    'uses' => 'DokumenController@storeDisposisi']);

Route::get('/dokumen/{route_doc}/create_penerima/{tujuan_id}',[
        'as' => 'doc.create_penerima',
        'uses' => 'DokumenController@createPenerima']);

Route::post('/dokumen/{route_doc}/store_penerima/{tujuan_id}',[
        'as' => 'doc.store_penerima',
        'uses' => 'DokumenController@storePenerima']);

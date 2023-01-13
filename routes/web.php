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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::post('/cek-email', 'UserController@email')->name('cek-email')->middleware('guest');
Route::get('/reset/password/{id}', 'UserController@password')->name('reset.password')->middleware('guest');
Route::patch('/reset/password/update/{id}', 'UserController@update_password')->name('reset.password.update')->middleware('guest');

//wajib login
Route::group(['middleware' => ['auth']], function () {

    //home
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    //Profil
    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::get('/profile/edit', 'UserController@edit_profile')->name('pengaturan.profile');
    Route::post('/profile/ubah-profile', 'UserController@ubah_profile')->name('pengaturan.ubah-profile');
    Route::get('/profile/email', 'UserController@edit_email')->name('pengaturan.email');
    Route::post('/profile/ubah-email', 'UserController@ubah_email')->name('pengaturan.ubah-email');
    Route::get('/profile/password', 'UserController@edit_password')->name('pengaturan.password');
    Route::post('/profile/ubah-password', 'UserController@ubah_password')->name('pengaturan.ubah-password');

    //admin, operator, wali kelas, guru
    //nilai
    Route::get('/nilai/view', 'NilaiController@view')->name('nilai');
    Route::get('/nilai/view/{id}', 'NilaiController@view_detail')->name('nilai.detail');
    Route::post('/nilai/acc', 'NilaiController@acc')->name('nilai.acc');
    Route::get('/nilai/rapor', 'NilaiController@rapor')->name('rapor');
    Route::get('/nilai/rapor/{id}', 'NilaiController@rapor_show')->name('rapor.show');
    Route::get('/nilai/rapor/detail/{id}', 'NilaiController@rapor_detail')->name('rapor.detail');
    Route::get('/nilai/rapor/pdf/{id}', 'NilaiController@raporpdf')->name('rapor.pdf');
    Route::resource('/nilai', 'NilaiController');

    //admin
    Route::group(['middleware' => ['role:admin']], function () {
        //mapel trash
        Route::get('/mapel/trash', 'MapelController@trash')->name('mapel.trash');
        Route::get('/mapel/restore/{id}', 'MapelController@restore')->name('mapel.restore');
        Route::delete('/mapel/kill/{id}', 'MapelController@kill')->name('mapel.kill');
        //guru trash
        Route::get('/guru/trash', 'GuruController@trash')->name('guru.trash');
        Route::get('/guru/restore/{id}', 'GuruController@restore')->name('guru.restore');
        Route::delete('/guru/kill/{id}', 'GuruController@kill')->name('guru.kill');
        //kelas trash
        Route::get('/kelas/trash', 'KelasController@trash')->name('kelas.trash');
        Route::get('/kelas/restore/{id}', 'KelasController@restore')->name('kelas.restore');
        Route::delete('/kelas/kill/{id}', 'KelasController@kill')->name('kelas.kill');
        //jadwal trash
        Route::get('/jadwal/trash', 'JadwalController@trash')->name('jadwal.trash');
        Route::get('/jadwal/restore/{id}', 'JadwalController@restore')->name('jadwal.restore');
        Route::delete('/jadwal/kill/{id}', 'JadwalController@kill')->name('jadwal.kill');
        //siswa trash
        Route::get('/siswa/trash', 'SiswaController@trash')->name('siswa.trash');
        Route::get('/siswa/restore/{id}', 'SiswaController@restore')->name('siswa.restore');
        Route::delete('/siswa/kill/{id}', 'SiswaController@kill')->name('siswa.kill');
        //tagihan trash
        Route::get('/tagihan/trash', 'TagihanController@trash')->name('tagihan.trash');
        Route::get('/tagihan/restore/{id}', 'TagihanController@restore')->name('tagihan.restore');
        Route::delete('/tagihan/kill/{id}', 'TagihanController@kill')->name('tagihan.kill');
        //user trash
        Route::get('/user/trash', 'UserController@trash')->name('user.trash');
        Route::get('/user/restore/{id}', 'UserController@restore')->name('user.restore');
        Route::delete('/user/kill/{id}', 'UserController@kill')->name('user.kill');
    });

    //admin, operator
    Route::group(['middleware' => ['role:admin|operator']], function () {
        //mapel
        Route::resource('/mapel', 'MapelController');
        //guru
        Route::resource('/guru', 'GuruController');
        Route::get('/guru/mapel/{id}', 'GuruController@mapel')->name('guru.mapel');
        Route::post('/guru/list_mapel', 'GuruController@getMapelGuru')->name('guru.listMapel');
        Route::post('/guru/import_excel', 'GuruController@import_excel')->name('guru.import_excel');
        //kelas
        Route::resource('/kelas', 'KelasController');
        Route::get('/kelas/edit/json', 'KelasController@getEdit');
        //jadwal
        Route::resource('/jadwal', 'JadwalController');
        Route::get('/jadwal/view/json', 'JadwalController@view');
        //siswa
        Route::resource('/siswa', 'SiswaController');
        Route::get('/siswa/view/json', 'SiswaController@view');
        Route::get('/siswa/kelas/{id}', 'SiswaController@kelas')->name('siswa.kelas');
        Route::post('/siswa/import_excel', 'SiswaController@import_excel')->name('siswa.import_excel');
        //tagihan
        Route::resource('/tagihan', 'TagihanController');
        Route::post('/tagihan/tagih', 'TagihanController@tagih')->name('tagihan.tagih');
        Route::get('/tagihan/edit/json', 'TagihanController@getEdit');
        //pembayaran
        Route::resource('/pembayaran', 'PembayaranController');
        Route::get('/pembayaran/view/json', 'PembayaranController@view');
        //user
        Route::resource('/user', 'UserController');
    });
});

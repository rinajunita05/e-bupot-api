<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengController;
use App\Http\Controllers\PPController;
use App\Http\Controllers\SPTController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportDataController;

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




// Route::middleware(['cors'])->group(function () {
Route::post('register', [AuthController::class, 'register']);
Route::get('pengaturan/{id}', [PengController::class, 'get_pengaturan']);
Route::post('pengaturan/{id}', [PengController::class, 'proses_tambah_pengaturan']);

Route::post('tambahpphsendiri/{user_id}', [PPController::class, 'proses_tambah_pphsendiri']);
Route::get('daftarpphsendiri/{user_id}', [PPController::class, 'get_pphsendiri']);
Route::get('pphsendiridelete/{id}', [PPController::class, 'hapus_pphsendiri']);
Route::get('get_pajakpenghasilan/{id}', [PPController::class, 'get_pajakpenghasilan']);
Route::post('pengaturan/{id}', [PengController::class, 'proses_tambah_pengaturan']);
Route::post('proses_edit_pphsendiri/{id}', [PPController::class, 'proses_edit_pphsendiri']);

Route::post('tambahpphpasal/{user_id}', [PPController::class, 'proses_tambah_pphpasal']);
Route::get('pphpasal/{user_id}', [PPController::class, 'get_pphpasal']);
Route::get('hapusdokumen/{id}', [PPController::class, 'hapus_dokumen']);
Route::post('proses_edit_pphpasal/{id}', [PPController::class, 'proses_edit_pphpasal']);
Route::get('hapus_pphpasal/{id}', [PPController::class, 'hapus_pphpasal']);
Route::get('update_posting/{user_id}', [PPController::class, 'update_posting']);

Route::post('tambahpphnon/{user_id}', [PPController::class, 'proses_tambah_pphnon']);
Route::get('pphnon/{user_id}', [PPController::class, 'get_pphnon']);
Route::post('proses_edit_pphnon/{id}', [PPController::class, 'proses_edit_pphnon']);
Route::get('hapus_dokumennon/{id}', [PPController::class, 'hapus_dokumennon']);
Route::get('hapus_pphnon/{id}', [PPController::class, 'hapus_pphnon']);

Route::post('importdata', [PPController::class, 'importdata']);
Route::get('import_data', [PPController::class, 'get_import_data']);
// Route::get('get_detail_importdata/{user_id}', [ImportDataController ::class, 'get_detail_importdata']);
Route::get('hapus_importdata/{id}', [PPController::class, 'hapus_importdata']);

Route::get('posting', [PPController::class, 'get_posting']);


Route::get('daftarbuktisetor', [SPTController::class, 'sptmasa']);
Route::post('tambah_buktisetor', [SPTController::class, 'proses_tambah_buktisetor']);
Route::get('hapus_buktisetor/{id}', [SPTController::class, 'hapus_buktisetor']);

Route::get('daftarbuktisetor', [SPTController::class, 'sptmasa']);
Route::post('tambah_buktisetor', [SPTController::class, 'proses_tambah_buktisetor']);
Route::get('dataRekamSPT' , [SPTController::class , 'data_RekamSPT']);
Route::get('hapus_buktisetor/{id}', [SPTController::class, 'hapus_buktisetor']);

Route::post('rekam-bukti-setor' , [SptmasaController::class , 'rekamSptMasa' ]);
Route::get('get_sptmasa/{user_id}', [SPTController::class, 'get_sptmasa']);
Route::get('get_penyiapansptmasa/{user_id}', [SPTController::class, 'get_penyiapansptmasa']);
Route::get('get_lengkapispt/{user_id}', [SPTController::class, 'get_lengkapispt']);
Route::get('get_kirimspt/{user_id}', [SPTController::class, 'get_kirimspt']);
Route::get('get_dbp1/{user_id}', [SPTController::class, 'get_dbp1']);
Route::post('simpan_doss_dopp/', [SPTController::class, 'simpan_doss_dopp']);
Route::get('get_dopp/{pajak_penghasilan_id}', [SPTController::class, 'get_dopp']);
Route::get('get_doss/{pajak_penghasilan_id}', [SPTController::class, 'get_doss']);
Route::post('tambah_spt/{user_id}', [SPTController::class, 'tambah_spt']);
Route::get('get_indukspt/{user_id}', [SPTController::class, 'get_indukspt']);
Route::get('update_id_billing/{sptmasa_id}', [SPTController::class, 'update_id_billing']);
Route::get('surat_billing/{id}', [SPTController::class, 'surat_billing']);
Route::get('surat_bpe/{id}', [SPTController::class, 'surat_bpe']);
Route::get('get_penandatangan', [SPTController::class, 'get_penandatangan']);
Route::post('simpan_penandatangan/', [SPTController::class, 'simpan_penandatangan']);
Route::get('get_dashboard/{user_id}', [SPTController::class, 'get_dashboard']);

// });
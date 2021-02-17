<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::resource('/v1/quan-ly-du-an', 'ProjectManagementApi');
Route::post('/v1/quan-ly-du-an/tim-kiem', 'ProjectManagementApi@searchAction')->name('project.management.search');
Route::get('/v1/danh-sach-du-an-tham-gia', 'ProjectManagementApi@findProjectsUserBelongsTo')->name('project.management.projects.user.belongs.to');

Route::get('/v1/du-lieu-input-output/load-data', 'InputOutputDataApi@loadData')->name('iodata.loaddata');
Route::resource('/v1/du-lieu-input-output', 'InputOutputDataApi');

Route::resource('/v1/directory', 'DirectoryApi');
Route::resource('/v1/thanh-vien', 'JointStaffApi');
Route::resource('/v1/thoi-gian-bao-gia', 'QuotationTimeApi');
Route::get('/v1/thoi-gian-bao-gia/export/{projectId}', 'QuotationTimeApi@exportQuotationTime')->name('quotation.time.export');

Route::resource('/v1/bien-phien-dich', 'TranslateApi');

Route::post('/v1/thoi-gian-bao-gia/import', 'QuotationTimeApi@importQuotationTime')->name('quotation.time.import');
Route::resource('/v1/bien-phien-dich', 'TranslateApi');

Route::resource('/v1/loi-ky-thuat', 'TechnicalErrorApi');
Route::get('/v1/loi-ky-thuat/export/{projectId}', 'TechnicalErrorApi@exportTechnicalError')->name('technical.error.export');

Route::resource('/v1/cong-viec-thuc-hien', 'WorkingTimeApi');
Route::get('/v1/cong-viec-thuc-hien/export/{projectId}', 'WorkingTimeApi@exportWorkingTime')->name('working.time.export');

Route::resource('/v1/kiem-soat-chat-luong', 'QualityManagementApi');

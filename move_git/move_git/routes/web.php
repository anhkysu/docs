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
Route::get('/', 'HomeController@indexAction')->name('home.index.page');
Route::get('/quan-ly-du-an/du-an/{id}', 'ProjectManagementController@viewProjectDetailAction')->name('view.project.page');

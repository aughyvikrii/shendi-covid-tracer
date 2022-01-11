<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\RegisterController;

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

Route::view('/', 'welcome')->name('welcome');

Route::post('/search', [MainController::class, 'search'])->name('action_search');
Route::get('/register', [RegisterController::class, 'view'])->name('register');
Route::post('/register', [RegisterController::class, 'action'])->name('register.action');

Route::get("kk/{id}", [MainController::class, 'kk_detail'])->name('kk');
Route::post('update_covid_status/{id}', [RegisterController::class, 'update_covid_status'])->name('update_covid_status');
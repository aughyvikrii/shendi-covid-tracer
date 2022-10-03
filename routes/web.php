<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\RegisterController;
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

Route::middleware('authMiddleware:out')->group(function(){
  Route::redirect("/", "/auth/login");

  Route::get("/auth/login", [AuthController::class, "v_login"]);
  Route::post("/auth/login", [AuthController::class, "post_login"]);

});

Route::middleware('authMiddleware:in')->group(function(){
  Route::view('/', 'welcome')->name('welcome');

  Route::get('/logout', function(){
    Auth::logout();

    return redirect("/auth/login");
  });
  
  Route::post('/search', [MainController::class, 'search'])->name('action_search');
  Route::get('/register', [RegisterController::class, 'view'])->name('register');
  Route::post('/register', [RegisterController::class, 'action'])->name('register.action');
  Route::post('/register_patient', [RegisterController::class, 'register_patient'])->name('register_patient');
  
  Route::get("/kk/{id}", [MainController::class, 'kk_detail'])->name('kk');
  Route::post('/update_covid_status/{id}', [RegisterController::class, 'update_covid_status'])->name('update_covid_status');
  Route::get('/print/{id}', [MainController::class, 'print'])->name('print');
  Route::get('/print_no_covid/{id}', [MainController::class, 'print_no_covid'])->name('print_no_covid');

  Route::get("/monitoring", [MainController::class, "monitoring"]);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomeAuthenticationController;

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

Route::get('/',[CustomeAuthenticationController::class,'login'])->name('user.login');
Route::get('/logout',[CustomeAuthenticationController::class,'logout'])->name('user.logout');

Route::get('/user_login',[CustomeAuthenticationController::class,'login'])->name('user.login')->middleware('AlreadyLoggedIn');
Route::post('/user_login',[CustomeAuthenticationController::class,'loginUser'])->name('user.loginUser');

Route::get('/register',[CustomeAuthenticationController::class,'registration'])->name('user.registration')->middleware('AlreadyLoggedIn');
Route::post('/user_register',[CustomeAuthenticationController::class,'registerUser'])->name('user.registration');


Route::get('/home',[CustomeAuthenticationController::class,'home'])->middleware('isLoggedIn');

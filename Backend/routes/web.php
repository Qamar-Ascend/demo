<?php

use App\Http\Controllers\AuthController;
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
    return view('welcome');
});
Route::get('auth/google', [AuthController::class, 'redirectToProvider'])->name('google-auth');
Route::get('/auth/google/call-back', [AuthController::class, 'googleCallBack']);
Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('google-auth');
Route::get('/auth/facebook/call-back', [AuthController::class, 'faceBookCallBack']);

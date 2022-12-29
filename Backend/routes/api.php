<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\UserController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::get('auth/google', [AuthController::class, 'redirectToProvider'])->name('google-auth');
Route::get('/auth/callback', function () {
    $user = Socialite::driver('facebook')->user();
    return $user;
    // $user->token
});
// Route::group(['middleware' => ['auth:web']], function () {
// });

//WITH AUTH APIS ROUTES
Route::group(['middleware' => ['auth:api']], function () {

    //USER API ROUTE
    Route::get('users', [UserController::class, 'get']);

    //SURVEY API ROUTE
    Route::post('surveyCreate', [SurveysController::class, 'store']);
    Route::get('surveys', [SurveysController::class, 'get']);
});

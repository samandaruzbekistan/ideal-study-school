<?php

use App\Http\Controllers\MobileApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('get-all-users', [MobileApiController::class, 'getUsers']);
Route::get('get-debt', [MobileApiController::class, 'getDebtMonths']);
Route::get('get-debt-month/{month?}', [MobileApiController::class, 'getDebtByMonth']);
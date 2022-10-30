<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\demoController;

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
Route::get('/demo', function () {
    return view('demo');
});
Route::get('/test', function () {
    return view('test');
});


Route::get('/points',[demoController::class,'getPoints']);

Route::post('/demo',[demoController::class,'uploadData']);

Route::get('/test-points',[demoController::class,'showPointsforJS']);
Route::get('/test-trace1',[demoController::class,'showTrace2PointsforJS']);

Route::get('/RTT',[demoController::class,'showRTT1Points']);
Route::get('/RTT2',[demoController::class,'showRTT2Points']);

Route::get('/Mag1',[demoController::class,'showMag1Points']);
Route::get('/Mag2',[demoController::class,'showMag2Points']);










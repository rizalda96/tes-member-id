<?php

use App\Http\Controllers\AwardController;
use App\Http\Controllers\LoginController;
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
    return view('app');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['prefix' => 'award', 'as' => 'award.'], function () {
    Route::get('/', [AwardController::class, 'search'])->name('get');
    // Route::post('/store', [StudentController::class, 'store'])->name('store');
    // Route::put('/update', [StudentController::class, 'update'])->name('update');
    // Route::get('/{id}/detail', [StudentController::class, 'show'])->name('show');
    // Route::get('/validate-code', [StudentController::class, 'validateCode'])->name('validate-code');
    // Route::delete('/drop', [StudentController::class, 'drop'])->name('drop');
});

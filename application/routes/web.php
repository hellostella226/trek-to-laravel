<?php

use App\Http\Controllers\OfferphiController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

const isDev = 1;
const location = 'develop';

Route::get('/', function () {
    return view('welcome');
});

Route::resource('offerphi', OfferphiController::class)
    ->only(['index'])
    ->middleware(['auth','verified']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

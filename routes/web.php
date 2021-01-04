<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\WireController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\CoilController;

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

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/new', [HomeController::class, 'newCoil'])->name('new');

Route::get('/{id?}', [HomeController::class, 'getCoil'])->name('getCoil');

Route::get('/design/{id}', [DesignController::class, 'getDesign'])->name('getDesign');

Route::get('/wire/{id}', [WireController::class, 'getWire'])->name('getWire');

Route::get('/material/{id}', [MaterialController::class, 'getMaterial'])->name('getMaterial');

Route::post('/calculate', [CalculateController::class, 'calculateCoil'])->name('calculate');

Route::post('/save', [HomeController::class, 'saveCoil'])->name('save');

Route::post('/update', [HomeController::class, 'updateCoil'])->name('update');

Route::get('/delcoil/{id}', [CoilController::class, 'delCoil'])->name('delCoil');

Route::get('/deldesign/{id}', [DesignController::class, 'delDesign'])->name('delDesign');

Route::get('/delwire/{id}', [WireController::class, 'delWire'])->name('delWire');

Route::get('/delmaterial/{id}', [MaterialController::class, 'delMaterial'])->name('delMaterial');



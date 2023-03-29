<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\DataController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Data list
Route::get('/dashboard', [DataController::class, 'data'])->name('dashboard');
Route::get('/data', [DataController::class, 'data'])->name('data');

// Data item
Route::post('/data/add', [DataController::class, 'add'])->name('data.add');
Route::get('/data/{data_id}', [DataController::class, 'dataItem'])->where('data_id', '[0-9]+')->name('data.item');
Route::post('/data/{data_id}/delete', [DataController::class, 'delete'])->where('data_id', '[0-9]+')->name('data.delete');
Route::post('/data/{data_id}/value/update', [DataController::class, 'dataValueUpdate'])->where('data_id', '[0-9]+')->name('data.item.value.update');

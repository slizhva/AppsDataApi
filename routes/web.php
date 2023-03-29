<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\AppsController;

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

// Apps
Route::get('/dashboard', [AppsController::class, 'apps'])->name('dashboard');
Route::get('/dashboard/apps', [AppsController::class, 'apps'])->name('dashboard.apps');

// App
Route::post('/dashboard/app/add', [AppsController::class, 'add'])->name('dashboard.app.add');
Route::get('/dashboard/app/{app_id}', [AppsController::class, 'app'])->where('app_id', '[0-9]+')->name('dashboard.app');
Route::post('/dashboard/app/{app_id}/delete', [AppsController::class, 'delete'])->where('app_id', '[0-9]+')->name('dashboard.app.delete');

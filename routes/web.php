<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\PasswordController;

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

Route::get('/', [MainController::class, 'main'])->name('main');
Route::get('/add/{type}', [MainController::class, 'add'])->name('add');
Route::post('/add/{type}/send', [MainController::class, 'addSend'])->name('add');
Route::get('/edit/{type}/{id}', [MainController::class, 'edit'])->name('edit');
Route::post('/edit/{type}/{id}/send', [MainController::class, 'editSend'])->name('edit');
Route::post('/delete/{type}/{id}', [MainController::class, 'delete'])->name('delete');
Route::get('/password', [PasswordController::class, 'password'])->name('password');
Route::get('/password/{password}', [PasswordController::class, 'passwordCheck'])->name('passwordCheck');

Route::get('/license/{id}', [LicenseController::class, 'license']);
Route::get('/license/{id}/edit', [LicenseController::class, 'licenseEdit']);

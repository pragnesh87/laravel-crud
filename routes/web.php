<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::group(['name' => 'user', 'as' => 'user.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('create', [UserController::class, 'create'])->name('create');
    Route::post('save', [UserController::class, 'store'])->name('save');
    Route::get('edit', [UserController::class, 'edit'])->name('edit');
    Route::put('update', [UserController::class, 'update'])->name('update');
    Route::delete('delete', [UserController::class, 'destroy'])->name('delete');
    Route::get('list', [UserController::class, 'list'])->name('list');
});
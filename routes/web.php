<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * File Upload Routes
 */
Route::get('/files', [App\Http\Controllers\FilesController::class, 'index'])->name('files.index');
Route::get('/files/add', [App\Http\Controllers\FilesController::class, 'create'])->name('files.create');
Route::post('/files/add', [App\Http\Controllers\FilesController::class, 'store'])->name('files.store');

/**
 * Employee matches page
 */
Route::get('/matches/{id}', [App\Http\Controllers\MatchesController::class, 'getMatches'])->name('matches.getMatches');



<?php

use App\Http\Controllers\FormController;
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

Route::get('/form/create', function () {
    return view('form.create');
});
Route::get('/form/{key}', [FormController::class, 'show'])->name('form.show');
Route::post('/form', [FormController::class, 'store'])->name('form.store');
Route::post('/form/answer', [FormController::class, 'storeAnswers'])->name('form.answer');
Route::get('/form/{id}/answer', [FormController::class, 'showAnswer'])->name('form.showAnswer');

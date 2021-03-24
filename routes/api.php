<?php

use App\Http\Controllers\API\FormController;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/form/{key}', [FormController::class, 'show']);
Route::post('/form', [FormController::class, 'store']);
Route::delete('/form/destory', [FormController::class, 'destroy']);
Route::get('/answers/{key}', [FormController::class, 'showAnswers']);
Route::post('/answers', [FormController::class, 'storeAnswers']);
Route::post('/answers_files', [FormController::class, 'storeFiles']);
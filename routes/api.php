<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RPAController;
use App\Http\Controllers\FileimgController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('rpa-job')->group(function () {
    Route::get('/job/{api_key}', [RPAController::class, 'getJobsForVm']);
    Route::patch('/job/{api_key}/{job_id}/update', [RPAController::class, 'updateJobStatus']);
    Route::get('/fileimg/download/{id}', [FileimgController::class, 'download'])->name('fileimg.download');
});

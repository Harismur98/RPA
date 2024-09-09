<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RPAController;



Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::get('/dashboard', function () {
        return view('index');
    });
    Route::resource('/users', UserController::class);
    Route::resource('vms', VMController::class);
    Route::get('/generate-api-key', [VMController::class, 'generateApiKey'])->name('generate.api.key');

    Route::prefix('rpa')->group(function () {
        Route::prefix('process')->group(function () {
            Route::get('/index', [RPAController::class, 'processIndex'])->name('rpa.process.index');
            Route::post('/store', [RPAController::class, 'processStore'])->name('rpa.process.store');
            Route::post('/edit/{id}', [RPAController::class, 'processEdit'])->name('rpa.process.edit');
            Route::post('/destroy/{id}', [RPAController::class, 'processDestroy'])->name('rpa.process.destroy');
        });

        Route::prefix('process-step')->group(function () {
            Route::get('/index', [RPAController::class, 'process_step_index'])->name('rpa.process_step.index');
            Route::post('/store', [RPAController::class, 'process_step_store'])->name('rpa.process_step.store');
        });

        Route::prefix('process-task')->group(function () {
            Route::get('/index', [RPAController::class, 'process_task_index'])->name('rpa.process_task.index');
            Route::post('/store', [RPAController::class, 'process_task_store'])->name('rpa.process_task.store');
        });
    });

});
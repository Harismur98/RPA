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
    Route::get('/get-vm', [VMController::class, 'getVM'])->name('get.vm');
    Route::get('/generate-api-key', [VMController::class, 'generateApiKey'])->name('generate.api.key');

    Route::prefix('rpa')->group(function () {
        Route::prefix('process')->group(function () {
            Route::get('/index', [RPAController::class, 'processIndex'])->name('rpa.process.index');
            Route::post('/store', [RPAController::class, 'processStore'])->name('rpa.process.store');
            Route::post('/edit/{id}', [RPAController::class, 'processEdit'])->name('rpa.process.edit');
            Route::post('/destroy/{id}', [RPAController::class, 'processDestroy'])->name('rpa.process.destroy');
            Route::get('/get-processes', [RPAController::class, 'getProcesses'])->name('get.processes');
        });

        Route::prefix('process-step')->group(function () {
            Route::get('/index', [RPAController::class, 'process_step_index'])->name('rpa.process_step.index');
            Route::post('/store', [RPAController::class, 'process_step_store'])->name('rpa.process_step.store');
            Route::post('/edit/{id}', [RPAController::class, 'process_step_edit'])->name('rpa.process_step.edit');
            Route::post('/destroy/{id}', [RPAController::class, 'process_step_destroy'])->name('rpa.process_step.destroy');
        });

        Route::prefix('process-task')->group(function () {
            Route::get('/index', [RPAController::class, 'process_task_index'])->name('rpa.process_task.index');
            Route::post('/store', [RPAController::class, 'process_task_store'])->name('rpa.process_task.store');
            Route::post('/edit/{id}', [RPAController::class, 'process_task_edit'])->name('rpa.process_task.edit');
            Route::post('/destroy/{id}', [RPAController::class, 'process_task_destroy'])->name('rpa.process_task.destroy');
        });

        Route::prefix('template')->group(function () {
            Route::get('/index', [RPAController::class, 'template_index'])->name('rpa.template.index');
            Route::post('/store', [RPAController::class, 'template_store'])->name('rpa.template.store');
            Route::post('/edit/{id}', [RPAController::class, 'template_edit'])->name('rpa.template.edit');
            Route::post('/template/update', [RPAController::class, 'updateTemplate'])->name('rpa.template.update');
            Route::post('/destroy/{id}', [RPAController::class, 'template_destroy'])->name('rpa.template.destroy');
        });

        Route::prefix('job')->group(function () {
            Route::post('/add-job/{id}', [RPAController::class, 'addJob'])->name('rpa.template.addJob');
            
        });

        Route::prefix('rpa-action')->group(function (){
            Route::get('/index', [RPAController::class, 'rpa_action_index'])->name('rpa.action.index');
            Route::post('/store', [RPAController::class, 'rpa_action_store'])->name('rpa.action.store');
            Route::post('/edit/{id}', [RPAController::class, 'rpa_action_edit'])->name('rpa.action.edit');
            Route::post('/destroy/{id}', [RPAController::class, 'rpa_action_destroy'])->name('rpa.action.destroy');

            Route::get('/api', [RPAController::class, 'rpa_action_api'])->name('rpa.action.api');
        });
    });

});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VMController;


Route::get('/', function () {
    return view('index');
});

Route::resource('vms', VMController::class);


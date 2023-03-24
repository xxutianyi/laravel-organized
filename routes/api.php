<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System as System;
use App\Http\Controllers\Resource as Resource;

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

Route::prefix('system')->group(function () {

    Route::get('initial-state', System\InitialStateController::class)->name('initial-state');

    Route::get('select/users', [System\SelectItemsController::class, 'users'])->name('select.users');
    Route::get('select/teams', [System\SelectItemsController::class, 'teams'])->name('select.teams');

});

Route::prefix('resource')->group(function () {

    Route::apiResource('users', Resource\UserController::class)->names('resource.users');
    Route::apiResource('teams', Resource\TeamController::class)->names('resource.teams');

});

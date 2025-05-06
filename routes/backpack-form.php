<?php

/*
|--------------------------------------------------------------------------
| MedianetDev\BackpackForm Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the MedianetDev\BackpackForm package.
|
*/


/**
 * Admin Routes
 */

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::crud('formbuilder', \MedianetDev\BackpackForm\Http\Controllers\Admin\FormbuilderCrudController::class);
    Route::crud('formbuilderentry', \MedianetDev\BackpackForm\Http\Controllers\Admin\FormbuilderEntryCrudController::class);
    Route::crud('formbuilder/{id_form}/formbuilderentry', \MedianetDev\BackpackForm\Http\Controllers\Admin\FormbuilderEntryCrudController::class);
});
Route::controller(\MedianetDev\BackpackForm\Http\Controllers\FormbuilderEntryController::class)
    ->prefix('formbuilder')
    ->middleware(array_merge(
        (array) config('backpack.base.web_middleware', 'web')
    ))
    ->group(
        function () {
            Route::get('/add-entry/{id}', 'show')->name('showformbuilderentry');
            Route::post('/add-entry', 'store')->name('storeformbuilderentry');
        }
    );

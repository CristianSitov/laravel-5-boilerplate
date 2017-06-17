<?php

/**
 * All route names are prefixed with 'admin.access'.
 */
Route::group([
    'prefix'     => 'heritage',
    'as'         => 'heritage.',
    'namespace'  => 'Heritage',
], function () {

    /*
     * Heritage Management
     */
    Route::group([
        'middleware' => 'access.routeNeedsRole:1',
    ], function () {
        /*
        * Heritage Resource Management
        */
        Route::group(['namespace' => 'Resource'], function () {
            Route::resource('resource', 'ResourceController');

            //For DataTables
            Route::post('resource/get', 'ResourceTableController')->name('resource.get');
        });
    });
});

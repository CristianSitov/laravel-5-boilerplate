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
        'middleware' => 'access.routeNeedsPermission:view-backend;scout',
    ], function () {
        /*
        * Heritage Resource Management
        */
        Route::group(['namespace' => 'Resource'], function () {
            Route::resource('resource', 'ResourceController');
            Route::put('resource/{resource}/restore', 'ResourceController@restore')
                ->name('resource.restore');

            // For DataTables
            Route::post('resource/get', 'ResourceTableController')
                ->name('resource.get');
        });
        /*
        * Heritage Resource Classification Type Management
        */
        Route::group(['namespace' => 'ResourceTypeClassification'], function () {
            Route::resource('resource-type-classification', 'ResourceTypeClassificationController');

            // For DataTables
             Route::post('resource-type-classification/get', 'ResourceTypeClassificationTableController')
                 ->name('resource-type-classification.get');
        });
    });
});

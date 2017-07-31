<?php

/**
 * All route names are prefixed with 'admin.access'.
 */
Route::group([
    'prefix'     => 'heritage',
    'as'         => 'heritage.',
    'namespace'  => 'Heritage',
], function () {

    Route::group([
        'middleware' => 'access.routeNeedsPermission:view-backend;scout',
    ], function () { // 'before' => 'auth'
        Route::get('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
        Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\LfmController@upload');
        // list all lfm routes here...
    });

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
        Route::group([
            'namespace' => 'Building',
            'prefix'    => 'resource/{resource}',
        ], function () {
            Route::resource('buildings', 'BuildingController');
            Route::get('buildings/{building}/remove', 'BuildingController@remove')->name('buildings.remove');
        });
        Route::group([
            'namespace' => 'Component',
            'prefix'    => 'resource/{resource}/building/{building}',
        ], function () {
            Route::resource('components', 'ComponentController');
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

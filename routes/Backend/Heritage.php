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
            Route::post('/component/{component_id}/upload', 'UploadController@uploadImage')
                ->name('resource.photos_upload');
            Route::delete('/component/{component_id}/upload/{id}/delete', 'UploadController@deleteImage')
                ->name('resource.photos_delete');
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
            Route::get('components/{component}/element/{element}/delete', 'ComponentController@destroyElement')->name('components.element.remove');
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

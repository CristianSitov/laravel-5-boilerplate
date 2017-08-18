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
        'middleware' => 'access.routeNeedsPermission:view-backend',
    ], function () {
        /*
        * Heritage Resource Management
        */
        Route::group([
            'namespace' => 'Resource',
            'middleware' => 'access.routeNeedsPermission:desk',
        ], function () {
            // Common REST
            Route::get('resource/{resource}/edit', 'ResourceController@edit')->name('resource.edit');
            Route::put('resource/{resource}', 'ResourceController@update')->name('resource.update');
            Route::delete('resource/{resource}', 'ResourceController@destroy')->name('resource.destroy');
            Route::put('resource/{resource}/restore', 'ResourceController@restore')->name('resource.restore');
        });
        Route::group([
            'namespace' => 'Resource',
            'middleware' => 'access.routeNeedsPermission:scout',
        ], function () {
            // For DataTables
            Route::post('resource/get', 'ResourceTableController@index')->name('resource.get');
            // Common REST
            Route::get('resource', 'ResourceController@index')->name('resource.index');
            Route::get('resource/create', 'ResourceController@create')->name('resource.create');
            Route::get('resource/{resource}', 'ResourceController@show')->name('resource.show');
            Route::post('resource', 'ResourceController@store')->name('resource.store');
            // For Uploading images
            Route::post('/component/{component_id}/upload', 'UploadController@uploadImage')->name('resource.photos_upload');
            Route::delete('/component/{component_id}/upload/{id}/delete', 'UploadController@deleteImage')->name('resource.photos_delete');
        });
        Route::group([
            'middleware' => 'access.routeNeedsPermission:view-backend;scout',
            'namespace' => 'Building',
            'prefix'    => 'resource/{resource}',
        ], function () {
            Route::resource('buildings', 'BuildingController');
            Route::get('buildings/{building}/remove', 'BuildingController@remove')->name('buildings.remove');
        });
        Route::group([
            'middleware' => 'access.routeNeedsPermission:view-backend;scout',
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

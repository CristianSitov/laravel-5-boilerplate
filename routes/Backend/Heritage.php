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
            Route::get('resource/{resource}/actors', 'ResourceController@actors')->name('resource.actors.index');
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
            Route::get('components', 'ComponentController@index')->name('components.index');
            Route::get('components/create/{type}', 'ComponentController@create')->name('components.create');
            Route::get('components/{component}/edit', 'ComponentController@edit')->name('components.edit');
            Route::put('components/{component}/update', 'ComponentController@update')->name('components.update');
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

        /*
        * Actors
        */
        Route::group(['namespace' => 'Actor'], function () {
            Route::resource('actors', 'ActorsController');
            Route::get('actors/{actor}/restore', 'ActorsController@create')->name('actors.restore');
            Route::get('resource/{resource}/actors/create', 'ActorsController@create')->name('resource.actors.create');
            Route::get('resource/{resource}/actors/{actor}/edit', 'ActorsController@edit')->name('resource.actors.edit');
            Route::put('resource/{resource}/actors/{actor}/update', 'ActorsController@update')->name('resource.actors.update');
            Route::get('resource/{resource}/actors/{actor}/detach', 'ActorsController@detach')->name('resource.actors.detach');

             // For DataTables
             Route::post('actors/get', 'ActorsTableController')
                 ->name('actors.table.get');
        });
    });
});

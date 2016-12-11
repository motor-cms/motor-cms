<?php
Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Motor\CMS\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation'
    ]
], function () {
    Route::resource('navigations', 'NavigationsController', ['except' => [
        'index', 'create'
    ]]);
    Route::get('navigations/{navigation}', 'NavigationsController@index')->name('navigations.index');
    Route::get('navigations/{navigation}/create', 'NavigationsController@create')->name('navigations.create');

    Route::resource('navigation_trees', 'NavigationTreesController', ['parameters' => [
        'navigation_trees' => 'navigation'
    ]]);
});

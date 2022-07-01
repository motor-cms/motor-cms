<?php

Route::group([
    'middleware' => [
        'auth:api',
        'bindings',
        'permission',
    ],
    'namespace'  => 'Motor\CMS\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::apiResource('navigation_trees', 'NavigationTreesController', [
        'parameters' => [
            'navigation_trees' => 'navigation',
        ],
    ]);
    Route::apiResource('navigation_trees/{navigation_tree}/navigations', 'NavigationsController');
    Route::apiResource('pages', 'PagesController');
    Route::apiResource('pages/{page}/page_versions', 'PageVersionsController')->except('store');
});

Route::group([
    'namespace'  => 'Motor\CMS\Http\Controllers\Api\Frontend',
    'prefix'     => 'api/frontend',
    'as'         => 'api.frontend.',
    'middleware' => [],
], static function () {
    Route::get('{slug}', 'PagesController@index')
         ->name('pages.index')
         ->where('slug', '[0-9a-zA-Z\/\-]+');
});

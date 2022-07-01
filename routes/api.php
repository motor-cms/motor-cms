<?php

use Motor\CMS\Http\Controllers\Api\NavigationsController;
use Motor\CMS\Http\Controllers\Api\NavigationTreesController;
use Motor\CMS\Http\Controllers\Api\PagesController;
use Motor\CMS\Http\Controllers\Api\Frontend\PagesController as FrontendPagesController;
use Motor\CMS\Http\Controllers\Api\PageVersionsController;

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
    Route::apiResource('navigation_trees', NavigationTreesController::class, [
        'parameters' => [
            'navigation_trees' => 'navigation',
        ],
    ]);
    Route::apiResource('navigation_trees/{navigation_tree}/navigations', NavigationsController::class);
    Route::apiResource('pages', PagesController::class);
    Route::apiResource('pages/{page}/page_versions', PageVersionsController::class)
         ->except('store');
});

Route::group([
    'namespace'  => 'Motor\CMS\Http\Controllers\Api\Frontend',
    'prefix'     => 'api/frontend',
    'as'         => 'api.frontend.',
    'middleware' => [],
], static function () {
    Route::get('{slug}', [FrontendPagesController::class, 'index'])
         ->name('pages.index')
         ->where('slug', '[0-9a-zA-Z\/\-]+');
});

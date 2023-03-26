<?php

use Motor\CMS\Http\Controllers\Backend\Component\ComponentTextsController;
use Motor\CMS\Http\Controllers\Backend\NavigationsController;
use Motor\CMS\Http\Controllers\Backend\NavigationTreesController;
use Motor\CMS\Http\Controllers\Backend\PagesController;
use Motor\CMS\Http\Controllers\Frontend\PagesController as FrontendPagesController;
use Motor\CMS\Http\Controllers\Component\BaseController;

Route::group([
    'as'         => 'backend.',
    'prefix'     => 'backend',
    'namespace'  => 'Motor\CMS\Http\Controllers\Backend',
    'middleware' => [
        'web',
        'web_auth',
        'navigation',
    ],
], static function () {
    Route::resource('navigations', NavigationsController::class, [
        'except' => [
            'index',
            'create',
        ],
    ]);
    Route::get('navigations/{navigation}', [NavigationsController::class, 'index'])
         ->name('navigations.index');
    Route::get('navigations/{navigation}/create', [NavigationsController::class, 'create'])
         ->name('navigations.create');

    Route::resource('navigation_trees', NavigationTreesController::class, [
        'parameters' => [
            'navigation_trees' => 'navigation',
        ],
    ]);

    Route::resource('pages', 'PagesController');
    Route::delete('pages/{page}/components/{page_version_component}', [PagesController::class, 'destroyComponent'])
         ->name('pages.components.delete');
    Route::get('pages/{page}/components', [PagesController::class, 'components'])
         ->name('pages.components.read');
    Route::get('pages/{page}/component_data', [PagesController::class, 'component_data'])
         ->name('pages.component_data.read');
    Route::patch('pages/{page}/component_data', [PagesController::class, 'patch_component_data'])
         ->name('pages.component_data.update');
});

//Route::redirect('/', '/start'); //'Motor\CMS\Http\Controllers\Frontend\PagesController@index')->name('pages.start');

Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Motor\CMS\Http\Controllers\Backend\Component',
    'middleware' => [
        'web',
        //'web_auth'
    ],
], static function () {
    // You only need this part if you already have a component group for the given namespace
    Route::get('texts', [ComponentTextsController::class, 'create'])
         ->name('texts.create');
    Route::post('texts', [ComponentTextsController::class, 'store'])
         ->name('texts.store');
    Route::get('texts/{component_text}', [ComponentTextsController::class, 'edit'])
         ->name('texts.edit');
    Route::patch('texts/{component_text}', [ComponentTextsController::class, 'update'])
         ->name('texts.update');
});
Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Motor\CMS\Http\Controllers\Component',
    'middleware' => [
        'web',
        //'web_auth'
    ],
], static function () {
    Route::resource('base', BaseController::class)
         ->only(['store', 'destroy']);
});

Route::group([
    'as'         => 'frontend.',
    'namespace'  => 'Motor\CMS\Http\Controllers\Frontend',
    'middleware' => [
        'web',
        'frontend',
    ],
], static function () {
    Route::get('{slug}', [FrontendPagesController::class, 'index'])
         ->name('pages.index')
         ->where('slug', '[0-9a-zA-Z\/\-]+');
    Route::post('{slug}', [FrontendPagesController::class, 'index'])
         ->name('pages.post')
         ->where('slug', '[0-9a-zA-Z\/\-]+');
    Route::patch('{slug}', [FrontendPagesController::class, 'index'])
         ->name('pages.patch')
         ->where('slug', '[0-9a-zA-Z\/\-]+');
});

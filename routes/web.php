<?php

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
    Route::resource('navigations', 'NavigationsController', [
        'except' => [
            'index',
            'create',
        ],
    ]);
    Route::get('navigations/{navigation}', 'NavigationsController@index')->name('navigations.index');
    Route::get('navigations/{navigation}/create', 'NavigationsController@create')->name('navigations.create');

    Route::resource('navigation_trees', 'NavigationTreesController', [
        'parameters' => [
            'navigation_trees' => 'navigation',
        ],
    ]);

    Route::resource('pages', 'PagesController');
    Route::delete('pages/{page}/components/{page_version_component}', 'PagesController@destroyComponent')
         ->name('pages.components.delete');
    Route::get('pages/{page}/components', 'PagesController@components')->name('pages.components.read');
    Route::get('pages/{page}/component_data', 'PagesController@component_data')->name('pages.component_data.read');
    Route::patch('pages/{page}/component_data', 'PagesController@patch_component_data')
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
    Route::get('texts', 'ComponentTextsController@create')->name('texts.create');
    Route::post('texts', 'ComponentTextsController@store')->name('texts.store');
    Route::get('texts/{component_text}', 'ComponentTextsController@edit')->name('texts.edit');
    Route::patch('texts/{component_text}', 'ComponentTextsController@update')->name('texts.update');
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
    Route::resource('base', 'BaseController')->only(['store', 'destroy']);
});

Route::group([
    'as'         => 'frontend.',
    'namespace'  => 'Motor\CMS\Http\Controllers\Frontend',
    'middleware' => [
        'web',
        'frontend',
    ],
], static function () {
    Route::get('{slug}', 'PagesController@index')->name('pages.index')->where('slug', '[0-9a-zA-Z\/\-]+');
    Route::post('{slug}', 'PagesController@index')->name('pages.index')->where('slug', '[0-9a-zA-Z\/\-]+');
    Route::patch('{slug}', 'PagesController@index')->name('pages.index')->where('slug', '[0-9a-zA-Z\/\-]+');
});

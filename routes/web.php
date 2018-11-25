<?php

use Illuminate\Container\Container;

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

    Route::resource('pages', 'PagesController');
    Route::delete('pages/{page}/components/{page_version_component}', 'PagesController@destroyComponent')->name('pages.components.delete');
    Route::get('pages/{page}/components', 'PagesController@components')->name('pages.components.read');
    Route::get('pages/{page}/component_data', 'PagesController@component_data')->name('pages.component_data.read');
    Route::patch('pages/{page}/component_data', 'PagesController@patch_component_data')->name('pages.component_data.update');
});

Route::group([
    'as'         => 'frontend.',
    'prefix'     => 'f',
    'namespace'  => 'Motor\CMS\Http\Controllers\Frontend',
    'middleware' => [
        'web',
        'frontend',
    ]
], function () {
    Route::get('{slug}', 'PagesController@index')->name('pages.index')->where('slug', '.*');
});


Route::group([
    'as'         => 'component.',
    'prefix'     => 'component',
    'namespace'  => 'Motor\CMS\Http\Controllers\Component',
    'middleware' => [
        'web',
        //'web_auth'
    ]
], function () {
    Route::resource('base', 'BaseController')->only(['store', 'destroy']);
    Route::resource('text', 'Basic\ComponentTextController', ['parameters' => ['text' => 'component_text']]);
});

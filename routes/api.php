<?php
Route::group([
    'middleware' => [
        'auth:api',
        'bindings',
        'permission'
    ],
    'namespace'  => 'Motor\CMS\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::resource('navigations', 'NavigationsController');
    //Route::resource('pages', 'PagesController');
});

Route::group([
    'namespace'  => 'Motor\CMS\Http\Controllers\Api\Frontend',
    'prefix'     => 'api/frontend',
    'as'         => 'api.frontend.',
    'middleware' => []
], static function () {
    Route::get('{slug}', 'PagesController@index')->name('pages.index')->where('slug', '[0-9a-zA-Z\/\-]+');
});

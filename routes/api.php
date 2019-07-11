<?php
Route::group([
    'middleware' => [ 'auth:api', 'bindings', 'permission' ],
    'namespace'  => 'Motor\CMS\Http\Controllers\Api',
    'prefix'     => 'api',
    'as'         => 'api.',
], static function () {
    Route::resource('navigations', 'NavigationsController');
    Route::resource('pages', 'PagesController');
});

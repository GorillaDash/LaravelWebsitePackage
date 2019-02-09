<?php

use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;

Route::get('website/config', 'WebsiteController@config')->middleware([DoNotCacheResponse::class]);
Route::get('query/{endpoint}', 'GorillaDashController@query');
Route::get('clear-cache', 'ClearCacheController@index')->middleware([DoNotCacheResponse::class]);
Route::get('map/{lat}/{lng}', 'StaticMapController@map');

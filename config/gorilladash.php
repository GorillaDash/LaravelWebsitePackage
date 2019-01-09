<?php

/*
|--------------------------------------------------------------------------
| Gorilla Dash - Laravel Website Settings
|--------------------------------------------------------------------------
|
| This file is for storing the credentials and settings to connect your
| Laravel website to Gorilla Dash.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Credentials
    |--------------------------------------------------------------------------
    |
    | These are available in your Gorilla Dash account
    |
    */

    'credentials' => [
        'website_id' => env('GORILLADASH_WEBSITE_ID'),
        'api_access_token' => env('GORILLADASH_API_ACCESS_TOKEN'),
        'public_key' => env('MIX_GORILLADASH_PUBLIC_KEY'),
    ],


    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | URL paths
    |
    */

    'paths' => [
        'tribes' => [
            'tribes_path' => env('GORILLADASH_TRIBE_PATH', 'stores'),
        ],
        'products' => [
            'products_path' => env('GORILLADASH_PRODUCT_PATH', 'products'),
            'categories_path' => env('GORILLADASH_CATEGORY_PATH', 'categories'),
            'ranges_path' => env('GORILLADASH_RANGE_PATH', 'ranges'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Cache set in seconds
    |
    */

    'cache' => [
        'seconds' => env('GORILLADASH_CACHE_SECONDS', 1800),
        'clear_cache_path' => env('GORILLADASH_CLEAR_CACHE_PATH', 'clear-cache'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | The routes configuration
    |
    */
    'routes' => [
        'middleware' => [
            \Spatie\ResponseCache\Middlewares\CacheResponse::class,
        ],
    ],
];

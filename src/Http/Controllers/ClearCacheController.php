<?php

namespace GorillaDash\LaravelWebsite\Http\Controllers;

use GorillaDash\LaravelWebsite\Commands\CacheWebsiteInfoCommand;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * Class ClearCacheController
 *
 * @package GorillaDash\LaravelWebsite\Http\Controllers
 */
class ClearCacheController extends Controller
{
    /**
     *
     */
    public function index()
    {
        ResponseCache::clear();
        Artisan::call(CacheWebsiteInfoCommand::class);
        return responder()->success([])->respond(201);
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Cache\Profiles;

use Illuminate\Http\Request;

/**
 * Class CacheAllSuccessfulGetRequests
 *
 * @package GorillaDash\LaravelWebsite\Cache\Profiles
 */
class CacheAllSuccessfulGetRequests extends \Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function shouldCacheRequest(Request $request): bool
    {
        if ($this->isRunningInConsole()) {
            return false;
        }

        return $request->isMethod('get');
    }
}

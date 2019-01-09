<?php

namespace GorillaDash\LaravelWebsite\Authentication;

use GorillaDash\LaravelWebsite\Exceptions\GorillaDashInvalidTokenException;

/**
 * Class AccessTokenManager
 *
 * @package GorillaDash\LaravelWebsite\Authentication
 */
class AccessTokenManager
{
    /**
     *
     */
    protected const PREFIX = 'gorilladash-client-';

    /**
     * @var \Illuminate\Support\Facades\Cache
     */
    private $cache;

    /**
     * AccessTokenManager constructor.
     *
     */
    public function __construct()
    {
        $this->cache = app()->make('cache');
    }


    /**
     * Returns access token.
     *
     * @param \GorillaDash\LaravelWebsite\Authentication\AccessToken|string|null $accessToken
     *
     * @return \GorillaDash\LaravelWebsite\Authentication\AccessToken|null
     */
    public function get($accessToken = null): ?AccessToken
    {
        if (\is_string($accessToken)) {
            return new AccessToken($accessToken);
        }
        if (!$accessToken) {
            $accessToken = $this->cache->get(self::PREFIX . '-token');
        }

        if ($accessToken instanceof AccessToken) {
            return !$accessToken->isExpired() ? $accessToken : null;
        }

        return null;
    }

    /**
     * Assign access token to cache.
     *
     * @param \GorillaDash\LaravelWebsite\Authentication\AccessToken $accessToken
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set(AccessToken $accessToken): void
    {
        $value = $accessToken->getValue();
        if (str_contains($value, '|')) {
            throw new GorillaDashInvalidTokenException();
        }
        $this->cache->set(self::PREFIX . '-token', $accessToken, $accessToken->getExpiredAt());
    }
}

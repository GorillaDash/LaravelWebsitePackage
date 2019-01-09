<?php

namespace GorillaDash\LaravelWebsite;

use GorillaDash\LaravelWebsite\Authentication\AccessToken;

/**
 * Class GorillaDashApp
 *
 * @package GorillaDash\LaravelWebsite
 */
class GorillaDashApp
{
    /**
     * @var int
     */
    protected $websiteId;

    /**
     * @var string
     */
    protected $apiToken;

    /**
     * GorillaDash constructor.
     *
     * @param int    $websiteId
     * @param string $apiToken
     */
    public function __construct(int $websiteId, string $apiToken)
    {
        $this->websiteId = $websiteId;
        $this->apiToken = $apiToken;
    }

    /**
     * Returns GorillaDash app id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->websiteId;
    }

    /**
     * Returns GorillaDash app token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->apiToken;
    }

    /**
     * Returns an app access token.
     *
     * @return \GorillaDash\LaravelWebsite\Authentication\AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return new AccessToken("{$this->getId()}|{$this->getToken()}");
    }
}

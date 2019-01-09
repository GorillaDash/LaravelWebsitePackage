<?php

namespace GorillaDash\LaravelWebsite\Requests;

/**
 * Class GorillaDashRequest
 *
 * @package GorillaDash\LaravelWebsite\Requests
 */
class GorillaDashRequest
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var array
     */
    private $params = [];

    /**
     * GorillaDashRequest constructor.
     *
     * @param null  $method
     * @param null  $endpoint
     * @param array $params
     */
    public function __construct($method = null, $endpoint = null, $params = [])
    {
        $this->setMethod($method);
        $this->setEndpoint($endpoint);
        $this->setParams($params);
    }

    /**
     * @param string $method
     *
     * @return \GorillaDash\LaravelWebsite\Requests\GorillaDashRequest
     */
    public function setMethod(?string $method): GorillaDashRequest
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $endpoint
     *
     * @return GorillaDashRequest
     */
    public function setEndpoint(?string $endpoint): GorillaDashRequest
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param array $params
     *
     * @return GorillaDashRequest
     */
    public function setParams(array $params = []): GorillaDashRequest
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}

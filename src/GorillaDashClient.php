<?php

namespace GorillaDash\LaravelWebsite;

use GorillaDash\LaravelWebsite\Middlewares\AuthorizeMiddleware;
use GorillaDash\LaravelWebsite\Requests\GorillaDashRequest;
use GorillaDash\LaravelWebsite\Responses\GorillaDashResponse;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

/**
 * Class GorillaDashClient
 *
 * @package GorillaDash\LaravelWebsite
 */
class GorillaDashClient
{
    /**
     * @const string Production GorillaDash API URL.
     */
    public const BASE_GORILLADASH_URL = 'https://api.gorilladash.com/';

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    private $stack;

    /**
     * GorillaDashClient constructor.
     *
     * @param \GorillaDash\LaravelWebsite\GorillaDashApp $app
     */
    public function __construct(GorillaDashApp $app)
    {
        $this->stack = new HandlerStack();
        $this->stack->setHandler(\GuzzleHttp\choose_handler());
        $this->stack->push(Middleware::mapRequest(new AuthorizeMiddleware($app, $this)));
        $this->client = new Client([
            'base_uri' => self::BASE_GORILLADASH_URL,
            'handler' => $this->stack,
        ]);
    }

    /**
     * @param \GorillaDash\LaravelWebsite\Requests\GorillaDashRequest $request
     *
     * @return \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GorillaDash\LaravelWebsite\Exceptions\GorillaDashSDKException
     */
    public function request(GorillaDashRequest $request): GorillaDashResponse
    {
        $options = $this->prepareRequestMessage($request);
        $response = $this->client->request($request->getMethod(), $request->getEndpoint(), $options);

        $returnResponse = new GorillaDashResponse(
            $request,
            $response->getBody()->getContents(),
            $response->getStatusCode(),
            $response->getHeaders()
        );

        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $returnResponse;
    }

    /**
     * Returns request body, headers
     *
     * @param \GorillaDash\LaravelWebsite\Requests\GorillaDashRequest $request
     *
     * @return array
     */
    private function prepareRequestMessage(GorillaDashRequest $request): array
    {
        $options = [
            $request->getMethod() === 'GET' ? 'query' : 'json' => $request->getParams(),
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
            ],
        ];

        return $options;
    }

    /**
     * @param $middleware
     */
    public function addMiddleware($middleware)
    {
        $this->stack->push($middleware);
    }
}

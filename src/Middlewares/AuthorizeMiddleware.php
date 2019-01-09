<?php

namespace GorillaDash\LaravelWebsite\Middlewares;

use GorillaDash\LaravelWebsite\Authentication\AccessToken;
use GorillaDash\LaravelWebsite\Authentication\AccessTokenManager;
use GorillaDash\LaravelWebsite\Authentication\OAuth2Client;
use GorillaDash\LaravelWebsite\GorillaDashApp;
use GorillaDash\LaravelWebsite\GorillaDashClient;
use Psr\Http\Message\RequestInterface;

/**
 * Class AuthorizeMiddleware
 */
class AuthorizeMiddleware
{
    /**
     * @var \GorillaDash\LaravelWebsite\GorillaDashApp
     */
    private $app;

    /**
     * @var \GorillaDash\LaravelWebsite\GorillaDashClient
     */
    private $client;

    /**
     * @var \GorillaDash\LaravelWebsite\Authentication\AccessTokenManager
     */
    private $accessTokenManager;

    /**
     * AuthorizeMiddleware constructor.
     *
     * @param \GorillaDash\LaravelWebsite\GorillaDashApp    $app
     * @param \GorillaDash\LaravelWebsite\GorillaDashClient $client
     */
    public function __construct(GorillaDashApp $app, GorillaDashClient $client)
    {
        $this->accessTokenManager = new AccessTokenManager();
        $this->app = $app;
        $this->client = $client;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return \Psr\Http\Message\RequestInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function __invoke(RequestInterface $request): RequestInterface
    {
        if ($this->passesUri($request)) {
            return $request;
        }
        if ($accessToken = $this->accessTokenManager->get(null)) {
            return $this->withHeader($request, $accessToken);
        }
        $oauthClient = new OAuth2Client($this->app, $this->client);
        if ($accessToken = $oauthClient->requestAnAccessToken()) {
            $this->accessTokenManager->set($accessToken);
        }

        return $this->withHeader($request, $accessToken);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface                          $request
     * @param \GorillaDash\LaravelWebsite\Authentication\AccessToken|null $accessToken
     *
     * @return mixed
     */
    private function withHeader(RequestInterface $request, ?AccessToken $accessToken)
    {
        return $request->withHeader('Authorization', "Bearer {$accessToken}");
    }

    /**
     * Pass the urls
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return bool
     */
    private function passesUri(RequestInterface $request)
    {
        return \in_array($request->getUri()->getPath(), ['/oauth/token'], true);
    }
}

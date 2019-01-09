<?php

namespace GorillaDash\LaravelWebsite\Authentication;

use GorillaDash\LaravelWebsite\Exceptions\GorillaDashSDKException;
use GorillaDash\LaravelWebsite\GorillaDashApp;
use GorillaDash\LaravelWebsite\GorillaDashClient;
use GorillaDash\LaravelWebsite\Requests\GorillaDashRequest;

/**
 * Class OAuth2Client
 *
 * @package GorillaDash\LaravelWebsite\Authentication
 */
class OAuth2Client
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
     * OAuth2Client constructor.
     *
     * @param \GorillaDash\LaravelWebsite\GorillaDashApp    $app
     * @param \GorillaDash\LaravelWebsite\GorillaDashClient $client
     */
    public function __construct(GorillaDashApp $app, GorillaDashClient $client)
    {
        $this->app = $app;
        $this->client = $client;
    }

    /**
     * Request an access token from GorillaDash Api
     *
     * @param array $params
     *
     * @return \GorillaDash\LaravelWebsite\Authentication\AccessToken
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function requestAnAccessToken(array $params = []): AccessToken
    {
        $response = $this->sendRequestWithClientParams('/oauth/token', $params);
        $data = $response->getDecodedBody();

        if (!($accessToken = data_get($data, 'access_token'))) {
            throw new GorillaDashSDKException('Access token was not returned from GorillaDash', 401);
        }

        $expiredAt = 0;
        if ($expires = data_get($data, 'expires_in')) {
            $expiredAt = time() + $expires;
        }

        return new AccessToken($accessToken, $expiredAt);
    }

    /**
     * Sends request with app access token
     *
     * @param string $endpoint
     * @param array  $params
     *
     * @return \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequestWithClientParams(string $endpoint, array $params = []): \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse // phpcs:ignore
    {
        $params = array_merge($this->requestTokenParams(), $params);
        $request = new GorillaDashRequest('POST', $endpoint, $params);

        return $this->client->request($request);
    }

    /**
     * Returns request token params.
     *
     * @return array
     */
    protected function requestTokenParams(): array
    {
        return array_merge(['grant_type' => 'client_credentials'], $this->getClientParams());
    }

    /**
     * Returns client params.
     *
     * @return array
     */
    protected function getClientParams(): array
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->app->getId(),
            'client_secret' => $this->app->getToken(),
        ];
    }
}

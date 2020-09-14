<?php

namespace GorillaDash\LaravelWebsite;

use Eastwest\Json\Json;
use GorillaDash\LaravelWebsite\Commands\CacheWebsiteInfoCommand;
use GorillaDash\LaravelWebsite\Queries\QueryAbstract;
use GorillaDash\LaravelWebsite\Queries\QueryCollection;
use GorillaDash\LaravelWebsite\Queries\QueryFactory;
use GorillaDash\LaravelWebsite\Requests\GorillaDashRequest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class GorillaDash
 *
 * @package GorillaDash\LaravelWebsite
 */
class GorillaDash
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
     * @var \GorillaDash\LaravelWebsite\Queries\QueryCollection
     */
    private $collection;

    /**
     * GorillaDash constructor.
     *
     * @param int    $websiteId
     * @param string $apiToken
     */
    public function __construct(int $websiteId, string $apiToken)
    {
        $this->app = new GorillaDashApp($websiteId, $apiToken);
        $this->client = new GorillaDashClient($this->app);
        $this->collection = new QueryCollection();
    }

    /**
     * Returns the GorillaDashApp entity.
     *
     * @return \GorillaDash\LaravelWebsite\GorillaDashApp
     */
    public function getApp(): GorillaDashApp
    {
        return $this->app;
    }


    /**
     * Sends a request to GorillaDash and returns the results.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @return \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $endpoint, $params = []): Responses\GorillaDashResponse
    {
        return $this->client->request(new GorillaDashRequest($method, $endpoint, $params));
    }

    /**
     * Fetch data
     *
     * @param string $query
     * @param array  $params
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch(string $query, $params = [])
    {
        return $this->create($query, $params)->get();
    }

    /**
     * Multiple queries in request
     *
     * @param array $queries
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function collect(array $queries): array
    {
        foreach ($queries as $query) {
            if ($query instanceof QueryAbstract) {
                $this->collection->push($query);
            } else {
                $this->collection->push(
                    $this->create(data_get($query, 'name'), data_get($query, 'params', []))->getQuery()
                );
            }
        }

        $body = $this->request('POST', '/graphql', [
            'query' => $this->collection->build(),
        ])->getDecodedBody();

        return data_get($body, 'data', []);
    }

    /**
     * Returns query
     *
     * @param string $name
     * @param array  $params
     *
     * @return \GorillaDash\LaravelWebsite\Queries\QueryAbstract
     */
    private function create(string $name, $params = []): Queries\QueryAbstract
    {
        return QueryFactory::create($name, $params);
    }

    /**
     * Json variables
     *
     * @return array
     */
    public static function jsonVariables(): array
    {
        if (!Storage::exists(CacheWebsiteInfoCommand::$path)) {
            Artisan::call(CacheWebsiteInfoCommand::class);
        }
        try {
            $result = Json::decode(Storage::get(CacheWebsiteInfoCommand::$path), true);
        } catch (FileNotFoundException $ex) {
            Log::error('Missing website info cache, and create fail');
            $result = [];
        }

        return $result;
    }
}

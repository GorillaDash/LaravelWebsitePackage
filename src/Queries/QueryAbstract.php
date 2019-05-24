<?php

namespace GorillaDash\LaravelWebsite\Queries;

use InvalidArgumentException;
use rdx\graphqlquery\Query;

/**
 * Class QueryAbstract
 *
 * @package GorillaDash\LaravelWebsite\src\Queries
 */
abstract class QueryAbstract
{
    /**
     * @var \GorillaDash\LaravelWebsite\GorillaDash
     */
    protected $gorilladash;

    /**
     * @var \rdx\graphqlquery\Query
     */
    protected $query;

    /**
     * @var string Query name
     */
    protected $queryName;

    /**
     * @var array Request params.
     */
    protected $params;

    /**
     * QueryAbstract constructor.
     *
     * @param array  $params
     * @param string $type
     */
    public function __construct(array $params = [], $type = Query::TYPE_QUERY)
    {
        $this->params = $params;
        $this->query = new GraphQLQuery($this->queryName, [], $type);
        $this->gorilladash = app()->make('laravelwebsite');
        $this->fields();
        $this->applyRequestParams();
    }

    /**
     * @return \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(): \GorillaDash\LaravelWebsite\Responses\GorillaDashResponse
    {
        if (!$this->query || !$this->query instanceof Query) {
            throw new InvalidArgumentException();
        }

        return $this->gorilladash->request('POST', '/graphql', [
            'query' => $this->query->build(),
        ]);
    }

    /**
     * Get results
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        $data = $this->request()->getDecodedBody();
        if (method_exists($this, 'transform')) {
            return $this->transform($data);
        }
        return $data;
    }

    /**
     * Returns query class
     *
     * @return \rdx\graphqlquery\Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Returns param value
     *
     * @param $key
     *
     * @return mixed
     */
    protected function getParam($key)
    {
        $value = data_get($this->params, $key);

        // cast value
        if ($value === 'true') {
            $value = true;
        }

        if ($value === 'false') {
            $value = false;
        }
        return $value;
    }

    /**
     * Defines fields
     * @return void
     */
    abstract protected function fields(): void;

    /**
     * Apply request params.
     */
    abstract protected function applyRequestParams(): void;

    /**
     * @param $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return data_get($data, "data.{$this->queryName}");
    }
}

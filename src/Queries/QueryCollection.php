<?php

namespace GorillaDash\LaravelWebsite\Queries;

use Illuminate\Support\Collection;
use rdx\graphqlquery\Query;

/**
 * Class QueryCollection
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class QueryCollection
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $collection;

    /**
     * QueryCollection constructor.
     *
     */
    public function __construct()
    {
        $this->collection = new Collection();
    }

    /**
     * Append the query to collection.
     *
     * @param \rdx\graphqlquery\Query $query
     *
     * @return \GorillaDash\LaravelWebsite\Queries\QueryCollection
     */
    public function push(Query $query): QueryCollection
    {
        $this->collection->push($query);

        return $this;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        $queryString = $this->collection->map(function (Query $query) {
            return $query->render(1);
        })->implode(PHP_EOL);

        $fragmentString = $this->collection->map(function (Query $query) {
            return $query->buildFragmentDefinitions();
        })->implode(PHP_EOL);

        return trim("query multipleQueries{\n{$queryString}}\n\n {$fragmentString} \n");
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Queries;

use rdx\graphqlquery\Query;

/**
 * Class GraphQLQuery
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class GraphQLQuery extends Query
{
    /**
     * @return string
     */
    public function buildFragmentDefinitions()
    {
        return parent::buildFragmentDefinitions();
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Mutations;

use Exception;
use GorillaDash\LaravelWebsite\Queries\QueryAbstract;
use Illuminate\Support\Arr;
use rdx\graphqlquery\Query;

/**
 * Class MutationAbstract
 *
 * @package GorillaDash\LaravelWebsite\Mutations
 */
abstract class MutationAbstract extends QueryAbstract
{
    /**
     * QueryAbstract constructor.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params, Query::TYPE_MUTATION);
    }

    /**
     * @param $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function transform($data)
    {
        if ($errors = Arr::get($data, 'errors')) {
            throw new Exception(
                implode(', ', Arr::pluck($errors, 'message'))
            );
        }
        return $data;
    }
}

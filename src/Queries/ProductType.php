<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class ProductType
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class ProductType extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'productType';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('productType');
        $this->query->productType->fields(
            'name',
            'description',
            'meta'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
    }
}

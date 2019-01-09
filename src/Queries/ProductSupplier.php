<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class ProductSupplier
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class ProductSupplier extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'productSuppliers';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('productSuppliers');
        $this->query->productSuppliers->fields(
            'name',
            'code'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Queries;

class WebsiteInfo extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'websiteInfo';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('websiteInfo');
        $this->query->websiteInfo->fields(
            'url',
            'base_products_path',
            'base_categories_path',
            'base_ranges_path',
            'base_tribes_path'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        // TODO: Implement applyRequestParams() method.
    }
}

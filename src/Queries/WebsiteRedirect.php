<?php

namespace GorillaDash\LaravelWebsite\Queries;


/**
 * Class WebsiteRedirect
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class WebsiteRedirect extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'websiteRedirects';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('websiteRedirects');
        $this->query->websiteRedirects->fields(
            'from',
            'to'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
    }
}

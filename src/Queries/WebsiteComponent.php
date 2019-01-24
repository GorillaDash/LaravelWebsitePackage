<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class WebsiteComponent
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class WebsiteComponent extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'websiteComponents';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('websiteComponents');
        $this->query->websiteComponents->fields(
            'name',
            'status',
            'components'
        );

        $this->query->websiteComponents->components->fields(
            'name',
            'slug',
            'contents'
        );

        $this->query->websiteComponents->components->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->websiteComponents->components->contents->media_collection->fields(
            'name',
            'media'
        );
        $this->query->websiteComponents->components->contents->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Add name filter
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->query->websiteComponents->attribute('name', $name);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($name = $this->getParam('name')) {
            $this->setName($name);
        }
    }
}

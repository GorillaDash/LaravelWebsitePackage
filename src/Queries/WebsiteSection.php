<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class WebsiteSection
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class WebsiteSection extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'websiteSections';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('websiteSections');
        $this->query->websiteSections->fields(
            'name',
            'contents'
        );
        $this->query->websiteSections->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );
        $this->query->websiteSections->contents->media_collection->fields(
            'name',
            'description',
            'media'
        );
        $this->query->websiteSections->contents->media_collection->media->fields(array_merge(
            ['alt_tag'],
            MediaSizeType::MEDIA_SIZES
        ));
    }

    /**
     * Add name filter
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->query->websiteSections->attribute('name', $name);
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

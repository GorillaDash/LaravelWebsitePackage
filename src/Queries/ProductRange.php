<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class ProductRange
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class ProductRange extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'ranges';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('ranges');
        $this->query->ranges->fields(
            'name',
            'menu_label',
            'status',
            'slug',
            'heading',
            'sub_heading',
            'caption',
            'description',
            'page_heading',
            'page_sub_heading',
            'path'
        );
    }

    /**
     * Add slug filter
     *
     * @param string $slug
     */
    private function setSlug(string $slug): void
    {
        $this->query->ranges->attribute('slug', $slug);
    }

    /**
     * Add result count filter
     *
     * @param int $count
     */
    private function setResultCount(int $count): void
    {
        $this->query->ranges->attribute('result_count', $count);
    }

    /**
     * Append components
     */
    private function appendComponents()
    {
        $this->query->ranges->fields(
            'componentTypes'
        );

        $this->query->ranges->componentTypes->fields(
            'name',
            'status',
            'base_path',
            'components'
        );

        $this->query->ranges->componentTypes->components->fields(
            'name',
            'slug',
            'contents'
        );

        $this->query->ranges->componentTypes->components->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->ranges->componentTypes->components->contents->media_collection->fields(
            'name',
            'media'
        );

        $this->query->ranges->componentTypes->components->contents->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Append products
     */
    private function appendProducts()
    {
        $this->query->ranges->fields(
            'products'
        );

        $this->query->ranges->products->fields(
            'name',
            'menu_label',
            'status',
            'slug',
            'heading',
            'sub_heading',
            'caption',
            'description',
            'meta',
            'page_heading',
            'page_sub_heading',
            'path',
            'url',
            'media_collection'
        );

        $this->query->ranges->products->media_collection->fields(
            'name',
            'media'
        );

        $this->query->ranges->products->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }

        if ($onlyShop = $this->getParam('onlyShop')) {
            $this->setResultCount($onlyShop);
        }

        if ($this->getParam('includeComponents')) {
            $this->appendComponents();
        }

        if ($this->getParam('includeProducts')) {
            $this->appendProducts();
        }
    }
}

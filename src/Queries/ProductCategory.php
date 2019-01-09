<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class ProductCategory
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class ProductCategory extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'categories';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('categories');
        $this->query->categories->fields(
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
            'componentTypes'
        );

        $this->query->categories->componentTypes->fields(
            'name',
            'status',
            'base_path',
            'components'
        );
        $this->query->categories->componentTypes->components->fields(
            'name',
            'slug',
            'contents'
        );

        $this->query->categories->componentTypes->components->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->categories->componentTypes->components->contents->media_collection->fields(
            'name',
            'media'
        );

        $this->query->categories->componentTypes->components->contents->media_collection->media->fields(
            'original_cropped',
            'banner'
        );
    }

    /**
     * Add slug filter
     *
     * @param string $slug
     */
    private function setSlug(string $slug): void
    {
        $this->query->categories->attribute('slug', $slug);
    }


    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }
    }
}

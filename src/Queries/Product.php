<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class Product
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class Product extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'products';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('products');
        $this->query->products->fields(
            'name',
            'menu_label',
            'status',
            'slug',
            'heading',
            'sub_heading',
            'product_type',
            'caption',
            'description',
            'meta',
            'page_heading',
            'page_sub_heading',
            'media_collection',
            'componentTypes',
            'product_custom_data',
            'product_related_products',
            'path'
        );

        $this->query->products->product_type->fields(
            'name'
        );

        $this->query->products->product_categories->fields(
            'name',
            'slug'
        );

        $this->query->products->media_collection->fields(
            'name',
            'media'
        );

        $this->query->products->media_collection->media->fields(
            'original_cropped',
            'banner',
            'rectangle',
            'square',
            'tribes'
        );

        $this->query->products->media_collection->media->tribes->fields(
            'name',
            'slug'
        );

        $this->query->products->componentTypes->fields(
            'name',
            'status',
            'base_path',
            'components'
        );
        $this->query->products->componentTypes->components->fields(
            'name',
            'slug',
            'contents'
        );

        $this->query->products->componentTypes->components->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->products->componentTypes->components->contents->media_collection->fields(
            'name',
            'media'
        );

        $this->query->products->componentTypes->components->contents->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );

        $this->query->products->product_custom_data->fields(
            'name',
            'type',
            'value'
        );

        $this->query->products->product_related_products->fields(
            'name',
            'slug',
            'media_collection'
        );

        $this->query->products->product_related_products->media_collection->fields(
            'name',
            'media'
        );

        $this->query->products->product_related_products->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Add slug filter
     *
     * @param string $slug
     */
    private function setSlug(string $slug): void
    {
        $this->query->products->attribute('slug', $slug);
    }

    /**
     * Add only shop filter
     *
     * @param bool $value
     */
    private function setOnlyShop(bool $value): void
    {
        $this->query->products->attribute('onlyShop', $value);
    }

    /**
     * Add component name type filter
     * @param array $componentTypes
     */
    private function setComponentTypeNames(array $componentTypes)
    {
        $this->query->products->componentTypes->attribute('name', $componentTypes);
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
            $this->setOnlyShop($onlyShop);
        }

        if ($componentTypes = $this->getParam('componentTypes')) {
            $this->setComponentTypeNames($componentTypes);
        }
    }
}

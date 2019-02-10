<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

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
        $this->query->categories->attribute('slug', $slug);
    }

    /**
     * Append components
     */
    private function appendComponents()
    {
        $this->query->categories->fields(
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
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Append product ranges
     */
    private function appendRanges()
    {
        $this->query->categories->fields(
            'product_ranges'
        );

        $this->query->categories->product_ranges->fields(
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
            'path',
            'url',
            'media_collection'
        );

        $this->query->categories->product_ranges->media_collection->fields(
            'name',
            'media'
        );

        $this->query->categories->product_ranges->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Append products
     */
    private function appendProducts()
    {
        $this->query->categories->fields(
            'products'
        );

        $this->query->categories->products->fields(
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

        $this->query->categories->products->media_collection->fields(
            'name',
            'media'
        );

        $this->query->categories->products->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );

        if ($includeInventory = $this->getParam('includeInventory')) {
            dump($includeInventory);
            $this->query->categories->products->fields('inventories');
            $this->query->categories->products->inventories
                ->fields('unit_price', 'quantity', 'variants', 'id', 'customData');
            $this->query->categories->products->inventories->customData->fields('name', 'type', 'value');
            $this->query->categories->products->inventories->attribute('slug', $includeInventory);
        }
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }

        if ($this->getParam('includeComponents')) {
            $this->appendComponents();
        }

        if ($this->getParam('includeRanges')) {
            $this->appendRanges();
        }

        if ($this->getParam('includeProducts')) {
            $this->appendProducts();
        }
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Queries;

use Eastwest\Json\Json;
use Exception;
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
            'path',
            'product_categories',
            'features'
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
    private function setComponentTypeNames(array $componentTypes): void
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

        if ($this->getParam('includeMediaTribe')) {
            $this->includeMediaTribe();
        }

        if ($this->getParam('includeComponents')) {
            $this->includeComponents();
            if ($componentTypes = $this->getParam('componentTypes')) {
                $this->setComponentTypeNames($componentTypes);
            }
        }

        if ($this->getParam('includeRelatedProducts')) {
            $this->includeRelatedProducts();
        }

        if ($includeInventory = $this->getParam('includeInventory')) {
            $this->includeInventory($includeInventory);
        }
    }

    /**
     *
     */
    private function includeMediaTribe(): void
    {
        $this->query->products->media_collection->media->fields('tribes');
        $this->query->products->media_collection->media->tribes->fields(
            'name',
            'slug'
        );
    }

    /**
     *
     */
    private function includeComponents(): void
    {
        $this->query->product->fields([
            'componentTypes',
        ]);
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
    }

    /**
     *
     */
    private function includeRelatedProducts(): void
    {
        $this->query->products->fields(['product_custom_data']);
        $this->query->products->fields(['product_related_products']);
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
     * @param $includeInventory
     * @throws Exception
     */
    private function includeInventory($includeInventory): void
    {
        try {
            $decode = Json::decode($includeInventory, true);
            if (\count($decode) > 0) {
                $this->query->products->fields('inventories');
                $this->query->products->inventories->fields('unit_price', 'quantity', 'variants', 'id', 'customData');
                $this->query->products->inventories->customData->fields('name', 'type', 'value');

                if ($tribeSlug = data_get($decode, 'tribe_slug')) {
                    $this->query->products->attribute('inventory_tribe_slug', $tribeSlug);
                    $this->query->products->inventories->attribute('tribe_slug', $tribeSlug);
                }

                if ($tribeId = data_get($decode, 'tribe_id')) {
                    $this->query->products->attribute('inventory_tribe_id', (int)$tribeId);
                    $this->query->products->inventories->attribute('tribe_id', (int)$tribeId);
                }

                if ($id = data_get($decode, 'id')) {
                    $this->query->products->inventories->attribute('id', (int)$id);
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}

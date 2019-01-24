<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class TribeComponent
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeComponent extends Tribe
{
    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('tribes');
        $this->query->tribes->fields(
            'component_types'
        );
        $this->query->tribes->component_types->fields(
            'name',
            'status',
            'components'
        );
        $this->query->tribes->component_types->components->fields(
            'name',
            'slug',
            'contents'
        );
        $this->query->tribes->component_types->components->contents->fields(
            'name',
            'value',
            'type',
            'media_collection'
        );
        $this->query->tribes->component_types->components->contents->media_collection->fields(
            'name',
            'media'
        );
        $this->query->tribes->component_types->components->contents->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }
    /**
     * @param $name
     */
    public function setComponentTypeName($name): void
    {
        $this->query->tribes->component_types->attribute('componentTypeName', $name);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        parent::applyRequestParams();
        if ($name = $this->getParam('componentType')) {
            $this->setComponentTypeName($name);
        }
    }
}

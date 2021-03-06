<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class TribeMedia
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeMedia extends Tribe
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
            'media_collection'
        );
        $this->query->tribes->media_collection->fields(
            'name',
            'media'
        );
        $this->query->tribes->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }
}

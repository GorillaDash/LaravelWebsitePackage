<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class TribeOurWork
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeOurWork extends Tribe
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
            'ourWorks'
        );
        $this->query->tribes->ourWorks->fields(
            'heading',
            'sub_heading',
            'slug',
            'status',
            'article',
            'media_collection'
        );
        $this->query->tribes->ourWorks->media_collection->fields(
            'name',
            'media'
        );
        $this->query->tribes->ourWorks->media_collection->media->fields(
            'original_cropped',
            'rectangle'
        );
    }
}

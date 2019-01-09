<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class Tribe
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeContent extends Tribe
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
            'contents'
        );

        $this->query->tribes->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->tribes->contents->media_collection->fields(
            'name',
            'media'
        );

        $this->query->tribes->contents->media_collection->media->fields(
            'original_cropped'
        );
    }

    /**
     * @param $name
     */
    public function setTribeTypeName($name): void
    {
        $this->query->tribes->contents->attribute('tribeTypeName', $name);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        parent::applyRequestParams();
        if ($name = $this->getParam('tribeTypeName')) {
            $this->setTribeTypeName($name);
        }
    }
}

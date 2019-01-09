<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class TribeOpeningHours
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeOpeningHours extends Tribe
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
            'tribe_opening_hours'
        );
    }
}

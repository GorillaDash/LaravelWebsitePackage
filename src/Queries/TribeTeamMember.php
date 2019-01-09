<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class TribeTeamMember
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class TribeTeamMember extends Tribe
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
            'teamMembers'
        );
        $this->query->tribes->teamMembers->fields(
            'first_name',
            'last_name',
            'about',
            'role',
            'avatar'
        );
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class Tribe
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class Tribe extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'tribes';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('tribes');
        $this->query->tribes->fields(
            'name',
            'country',
            'postal_code',
            'state',
            'locality',
            'address_1',
            'address_2',
            'latitude',
            'longitude',
            'main_telephone',
            'slug',
            'heading',
            'sub_heading',
            'caption',
            'page_heading',
            'page_sub_heading',
            'introduction_bold',
            'introduction',
            'answer_number',
            'organic_number',
            'paid_number',
            'tracking_code',
            'introduction_team',
            'status',
            'meta_title',
            'meta_description',
            'opening_hours',
            'opening_hours_array',
            'show_opening_hours',
            'google_place_id',
            'paid_cid',
            'organic_cid'
        );
    }

    /**
     * Add name filter
     *
     * @param string $name
     */
    private function setName(string $name)
    {
        $this->query->tribes->attribute('name', $name);
    }

    /**
     * Add slug filter
     *
     * @param string $slug
     */
    private function setSlug(string $slug)
    {
        $this->query->tribes->attribute('slug', $slug);
    }

    /**
     * Add order by filter
     *
     * @param array $orderBy
     */
    private function setOrderBy(array $orderBy): void
    {
        $this->query->tribes->attribute('orderBy', $orderBy);
    }

    /**
     *
     */
    private function includeContents()
    {
        $this->query->tribes->fields('contents');
        $this->query->tribes->contents->fields('name', 'type', 'value', 'media_collection');
        $this->query->tribes->contents->media_collection->fields('name', 'description', 'media');
        $this->query->tribes->contents->media_collection->media->fields(MediaSizeType::MEDIA_SIZES);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($name = $this->getParam('name')) {
            $this->setName($name);
        }

        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }

        if ($order = $this->getParam('orderBy')) {
            $this->setOrderBy([$order]);
        }

        if ($this->getParam('includeContents')) {
            $this->includeContents();
        }

        if ($this->getParam('includeMedia')) {
            $this->includeMedia();
        }

        if ($this->getParam('includeTeamMembers')) {
            $this->includeTeamMembers();
        }

        if ($this->getParam('includeOurWorks')) {
            $this->includeOurWorks($this->getParam('ourWorkSlug'));
        }

        if ($this->getParam('includeTribeTypes')) {
            $this->includeTribeTypes();
        }
    }

    /**
     *
     */
    private function includeMedia()
    {
        $this->query->tribes->fields('media_collection');
        $this->query->tribes->media_collection->fields('name', 'description', 'media');
        $this->query->tribes->media_collection->media->fields(MediaSizeType::MEDIA_SIZES);
    }

    /**
     *
     */
    private function includeTeamMembers()
    {
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

    /**
     *
     */
    public function includeOurWorks($slug = null)
    {
        $this->query->tribes->fields('ourWorks');
        $this->query->tribes->ourWorks->fields(
            'heading',
            'sub_heading',
            'meta_title',
            'meta_description',
            'author',
            'article',
            'slug',
            'media_collection'
        );
        if ($slug) {
            $this->query->tribes->ourWorks->attribute('slug', $slug);
        }
        $this->query->tribes->ourWorks->media_collection->fields('name', 'description', 'media');
        $this->query->tribes->ourWorks->media_collection->media->fields(MediaSizeType::MEDIA_SIZES);
    }

    /**
     *
     */
    public function includeTribeTypes()
    {
        $this->query->tribes->fields('tribe_types');
        $this->query->tribes->tribe_types->fields(
            'name'
        );
    }
}

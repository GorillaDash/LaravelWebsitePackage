<?php

namespace GorillaDash\LaravelWebsite\Queries;

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
            'meta_description'
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
    }
}

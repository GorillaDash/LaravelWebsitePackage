<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class Review
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class Review extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'reviews';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->reviews->fields(
            'name',
            'review',
            'featured',
            'business_name'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('tribe_slug')) {
            $this->setTribeSlug($slug);
        }
        
        if ($tribeId = $this->getParam('tribe_id')) {
            $this->setTribeId($tribeId);
        }
        
        if ($featured = $this->getParam('featured')) {
            $this->setFeatured($featured);
        }
    }

    /**
     * Add tribe slug filter
     *
     * @param string $slug
     */
    private function setTribeSlug(string $slug): void
    {
        $this->query->reviews->attribute('tribe_slug', $slug);
    }

    /**
     * Add tribe id filter
     *
     * @param int $tribeId
     */
    private function setTribeId(int $tribeId): void
    {
        $this->query->reviews->attribute('tribe_id', $tribeId);
    }

    /**
     * Add featured filter
     *
     * @param bool $featured
     */
    private function setFeatured(bool $featured): void
    {
        $this->query->reviews->attribute('featured', $featured);
    }
}

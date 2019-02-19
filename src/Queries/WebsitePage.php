<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class WebsitePage
 *
 * @package GorillaDash\LaravelWebsite\src\Queries
 */
class WebsitePage extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'websitePages';

    /**
     * Define fields
     */
    protected function fields(): void
    {
        $this->query->fields('websitePages');
        $this->query->websitePages->fields(
            'name',
            'slug',
            'contents'
        );
        $this->query->websitePages->contents->fields(
            'name',
            'source',
            'type',
            'value',
            'media_collection'
        );
        $this->query->websitePages->contents->media_collection->fields(
            'name',
            'media'
        );
        $this->query->websitePages->contents->media_collection->media->fields(MediaSizeType::MEDIA_SIZES);
    }

    /**
     * Add slug filter
     *
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->query->websitePages->attribute('slug', $slug);
    }

    /**
     * Add types filter
     *
     * @param array $types
     */
    public function setTypes(array $types)
    {
        $this->query->websitePages->attribute('type', [$types]);
    }

    /**Add template type filter
     *
     * @param string $template
     */
    public function setTemplateType(string $template)
    {
        $this->query->websitePages->attribute('template_type', $template);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }

        if ($types = $this->getParam('types')) {
            $this->setTypes($slug);
        }

        if ($template = $this->getParam('template_type')) {
            $this->setTemplateType($template);
        }

        if ($this->getParam('includeComponents')) {
            $this->includeComponents();
        }
    }

    /**
     *
     */
    private function includeComponents()
    {
        $this->query->websitePages->fields('componentTypes');
        $this->query->websitePages->componentTypes->fields(
            'name',
            'status',
            'base_path',
            'components'
        );

        $this->query->websitePages->componentTypes->components->fields(
            'name',
            'slug',
            'contents'
        );

        $this->query->websitePages->componentTypes->components->contents->fields(
            'name',
            'type',
            'value',
            'media_collection'
        );

        $this->query->websitePages->componentTypes->components->contents->media_collection->fields(
            'name',
            'media'
        );

        $this->query->websitePages->componentTypes->components->contents->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }
}

<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;
use Illuminate\Support\Arr;

/**
 * Class Article
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class Article extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'articles';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('articles');
        $this->query->articles->fields(
            'heading',
            'sub_heading',
            'author',
            'slug',
            'abstract',
            'article',
            'media_collection'
        );
        $this->query->articles->media_collection->fields(
            'name',
            'media'
        );
        $this->query->articles->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($slug = $this->getParam('slug')) {
            $this->setSlug($slug);
        }

        if ($status = $this->getParam('status')) {
            $this->setStatus($status);
        }

        if ($categories = $this->getParam('categories')) {
            $this->setCategories($categories);
        }
    }

    /**
     * @param $slug
     */
    protected function setSlug($slug)
    {
        $this->query->articles->attribute('slug', $slug);
    }

    /**
     * @param $status
     */
    protected function setStatus($status)
    {
        $this->query->articles->attribute('status', $status);
    }

    /**
     * @param $categories
     */
    private function setCategories($categories)
    {
        $this->query->articles->attribute('categories', Arr::wrap($categories));
    }
}

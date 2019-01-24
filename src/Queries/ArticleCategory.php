<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Types\MediaSizeType;

/**
 * Class ArticleCategory
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class ArticleCategory extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'articleCategories';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('articleCategories');
        $this->query->articleCategories->fields(
            'name',
            'slug',
            'articles'
        );
        $this->query->articleCategories->articles->fields(
            'slug',
            'heading',
            'sub_heading',
            'author',
            'abstract',
            'media_collection'
        );
        $this->query->articleCategories->articles->media_collection->fields(
            'name',
            'media'
        );
        $this->query->articleCategories->articles->media_collection->media->fields(MediaSizeType::MEDIA_SIZES);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
    }
}

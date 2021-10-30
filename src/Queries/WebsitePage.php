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
        if ($this->getParam('includeRelatedProducts')) {
            $this->includeRelatedProducts();
        }

        if ($this->getParam('includeTribes')) {
            $this->includeTribes();
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


    /**
     *
     */
    private function includeRelatedProducts(): void
    {
        $this->query->websitePages->fields(['products']);
        $this->query->websitePages->products->fields(
            'name',
            'slug',
            'menu_label',
            'media_collection',
            'heading',
            'sub_heading',
            'caption',
            'description',
            'meta',
            'page_heading',
            'page_sub_heading',
            'product_custom_data'
        );

        $this->query->websitePages->products->media_collection->fields(
            'name',
            'media'
        );

        $this->query->websitePages->products->media_collection->media->fields(
            MediaSizeType::MEDIA_SIZES
        );

        $this->query->websitePages->products->product_custom_data->fields(
            'name',
            'type',
            'value'
        );
    }

    /**
     *
     */
    private function includeTribes()
    {
        $this->query->websitePages->fields(['tribes']);
        $this->query->websitePages->tribes->fields(
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
}

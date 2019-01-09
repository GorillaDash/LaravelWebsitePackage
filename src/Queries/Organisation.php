<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class Organisation
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class Organisation extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'organisation';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('organisation');
        $this->query->organisation->fields(
            'name',
            'all_media'
        );

        $this->query->organisation->all_media->fields(
            'id',
            'name',
            'description',
            'url',
            'star',
            'categories',
            'media'
        );

        $this->query->organisation->all_media->media->fields(
            'thumbnail',
            'banner',
            'square',
            'rectangle',
            'original_cropped',
            'portrait',
            'alt_tag'
        );
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($count = $this->getParam('count')) {
            $this->setMediaCount($count);
        }

        if ($order = $this->getParam('order')) {
            $this->setMediaOrder($order);
        }

        if ($desc = $this->getParam('desc')) {
            $this->setMediaDesc($desc);
        }

        if ($size = $this->getParam('size')) {
            $this->setMediaSize($size);
        }

        if ($id = $this->getParam('id')) {
            $this->setMediaId($id);
        }

        if ($star = $this->getParam('star')) {
            $this->setMediaStar($star);
        }
    }

    /**
     * Add media count filter
     *
     * @param int $count
     */
    private function setMediaCount(int $count): void
    {
        $this->query->organisation->all_media->attribute('count', $count);
    }

    /**
     * Add media order filter
     *
     * @param string $order
     */
    private function setMediaOrder(string $order): void
    {
        $this->query->organisation->all_media->attribute('order', $order);
    }

    /**
     * Add media desc filter
     *
     * @param bool $desc
     */
    private function setMediaDesc(bool $desc): void
    {
        $this->query->organisation->all_media->attribute('desc', $desc);
    }

    /**
     * Add media size filter
     *
     * @param array $size
     */
    private function setMediaSize(array $size): void
    {
        $this->query->organisation->all_media->attribute('size', $size);
    }

    /**
     * Add media id filter
     *
     * @param int $id
     */
    private function setMediaId(int $id): void
    {
        $this->query->organisation->all_media->attribute('id', $id);
    }

    /**
     * Add media star filter
     *
     * @param bool $star
     */
    private function setMediaStar(bool $star): void
    {
        $this->query->organisation->all_media->attribute('star', $star);
    }
}

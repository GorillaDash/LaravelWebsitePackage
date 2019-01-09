<?php

namespace GorillaDash\LaravelWebsite\Queries;

/**
 * Class WebsiteMenu
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class WebsiteMenu extends QueryAbstract
{
    /**
     * @var string Query name.
     */
    protected $queryName = 'menus';

    /**
     * Defines fields
     *
     * @return void
     */
    protected function fields(): void
    {
        $this->query->fields('menus');
        $this->query->menus->fields('name', 'menu_json');
    }

    /**
     * Add name filter
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->query->menus->attribute('name', $name);
    }

    /**
     * Apply request params.
     */
    protected function applyRequestParams(): void
    {
        if ($name = $this->getParam('name')) {
            $this->setName($name);
        }
    }
}

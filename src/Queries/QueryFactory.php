<?php

namespace GorillaDash\LaravelWebsite\Queries;

use GorillaDash\LaravelWebsite\Exceptions\GorillaDashInvalidQueryException;
use GorillaDash\LaravelWebsite\Mutations\MutationAbstract;
use GorillaDash\LaravelWebsite\Mutations\SubmitAppointment;
use GorillaDash\LaravelWebsite\Mutations\SubmitEnquiry;

/**
 * Class QueryFactory
 *
 * @package GorillaDash\LaravelWebsite\Queries
 */
class QueryFactory
{
    /**
     * @param       $endpoint
     * @param array $params
     *
     * @return \GorillaDash\LaravelWebsite\Queries\QueryAbstract
     */
    public static function create($endpoint, $params = []): ?QueryAbstract
    {
        switch ($endpoint) {
            case 'websitePages':
                return new WebsitePage($params);
            case 'websiteSections':
                return new WebsiteSection($params);
            case 'websiteComponents':
                return new WebsiteComponent($params);
            case 'websiteMenus':
                return new WebsiteMenu($params);
            case 'articleCategories':
                return new ArticleCategory($params);
            case 'articles':
                return new Article($params);
            case 'tribes':
                return new Tribe($params);
            case 'tribeMedia':
                return new TribeMedia($params);
            case 'tribeComponent':
                return new TribeComponent($params);
            case 'tribeOurWork':
                return new TribeOurWork($params);
            case 'tribeContent':
                return new TribeContent($params);
            case 'products':
                return new Product($params);
            case 'productRanges':
                return new ProductRange($params);
            case 'productCategories':
                return new ProductCategory($params);
            case 'productType':
                return new ProductType($params);
            case 'productSuppliers':
                return new ProductSupplier($params);
            case 'reviews':
                return new Review($params);
            case 'organisation':
                return new Organisation($params);
            case 'websiteInfo':
                return new WebsiteInfo($params);
            case 'submitEnquiry':
                return new SubmitEnquiry($params);
            case 'websiteRedirects':
                return new WebsiteRedirect($params);
            case 'submitAppointment':
                return new SubmitAppointment($params);
            default:
                throw new GorillaDashInvalidQueryException("Invalid query name: {$endpoint}");
        }
    }
}

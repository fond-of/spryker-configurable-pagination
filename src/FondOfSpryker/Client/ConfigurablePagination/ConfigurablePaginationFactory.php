<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilder;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface;
use Spryker\Client\Catalog\CatalogFactory;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig getConfig()
 */
class ConfigurablePaginationFactory extends CatalogFactory
{
    /**
     * @return \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface
     */
    public function createPaginationConfigBuilder(): PaginationConfigBuilderInterface
    {
        return new PaginationConfigBuilder($this->getConfig());
    }
}

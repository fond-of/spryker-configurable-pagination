<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder;
use FondOfSpryker\Client\Config\DefaultPaginationConfigBuilderInterface;
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

    /**
     * @return \FondOfSpryker\Client\Config\DefaultPaginationConfigBuilderInterface
     */
    public function createDefaultPaginationConfigBuilder(): DefaultPaginationConfigBuilderInterface
    {
        $defaultPaginationConfigBuilder = new DefaultPaginationConfigBuilder();

        $defaultPaginationConfigBuilder->setPaginationConfigTransfer(
            $this->createPaginationConfigBuilder()->build()
        );

        return $defaultPaginationConfigBuilder;
    }
}

<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Config;

use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface as PaginationConfigTransferBuilderInterface;
use Spryker\Client\Catalog\Plugin\Config\CatalogSearchConfigBuilder as BaseCatalogSearchConfigBuilder;
use Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory getFactory()
 */
class CatalogSearchConfigBuilder extends BaseCatalogSearchConfigBuilder
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface
     */
    protected $paginationConfigBuilder;

    /**
     * @param \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface $paginationConfigBuilder
     */
    public function __construct(PaginationConfigTransferBuilderInterface $paginationConfigBuilder)
    {
        $this->paginationConfigBuilder = $paginationConfigBuilder;
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface $paginationConfigBuilder
     *
     * @return void
     */
    public function buildPaginationConfig(PaginationConfigBuilderInterface $paginationConfigBuilder): void
    {
        $pagination = $this->paginationConfigBuilder->build();

        $paginationConfigBuilder->setPagination($pagination);
    }
}

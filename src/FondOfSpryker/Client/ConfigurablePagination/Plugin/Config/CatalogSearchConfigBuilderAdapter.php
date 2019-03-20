<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Config;

use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\Search\Dependency\Plugin\FacetConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\SortConfigBuilderInterface;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory getFactory()
 */
class CatalogSearchConfigBuilderAdapter extends AbstractPlugin implements SearchConfigBuilderInterface
{
    /**
     * @var \Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface
     */
    protected $baseCatalogSearchConfigBuilder;

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface $baseCatalogSearchConfigBuilder
     */
    public function __construct(SearchConfigBuilderInterface $baseCatalogSearchConfigBuilder)
    {
        $this->baseCatalogSearchConfigBuilder = $baseCatalogSearchConfigBuilder;
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\FacetConfigBuilderInterface $facetConfigBuilder
     *
     * @return void
     */
    public function buildFacetConfig(FacetConfigBuilderInterface $facetConfigBuilder): void
    {
        $this->baseCatalogSearchConfigBuilder->buildFacetConfig($facetConfigBuilder);
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\SortConfigBuilderInterface $sortConfigBuilder
     *
     * @return void
     */
    public function buildSortConfig(SortConfigBuilderInterface $sortConfigBuilder): void
    {
        $this->baseCatalogSearchConfigBuilder->buildSortConfig($sortConfigBuilder);
    }

    /**
     * @param \Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface $paginationConfigBuilder
     *
     * @return void
     */
    public function buildPaginationConfig(PaginationConfigBuilderInterface $paginationConfigBuilder): void
    {
        $pagination = $this->getFactory()->createPaginationConfigBuilder()->build();

        $paginationConfigBuilder->setPagination($pagination);
    }
}

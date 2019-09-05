<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Elasticsearch\ResultFormatter;

use Elastica\ResultSet;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory getFactory()
 */
class PaginatedResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    protected const NAME = 'pagination';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return \Generated\Shared\Transfer\PaginationSearchResultTransfer
     */
    protected function formatSearchResult(
        ResultSet $searchResult,
        array $requestParameters
    ): PaginationSearchResultTransfer {
        $defaultPaginationConfigBuilder = $this
            ->getFactory()
            ->createDefaultPaginationConfigBuilder();

        $itemsPerPage = $defaultPaginationConfigBuilder->getCurrentItemsPerPage($requestParameters);
        $maxPage = (int)ceil($searchResult->getTotalHits() / $itemsPerPage);
        $currentPage = min($defaultPaginationConfigBuilder->getCurrentPage($requestParameters), $maxPage);

        $paginationSearchResultTransfer = new PaginationSearchResultTransfer();

        $paginationSearchResultTransfer
            ->setNumFound($searchResult->getTotalHits())
            ->setCurrentPage($currentPage)
            ->setMaxPage($maxPage)
            ->setCurrentItemsPerPage($itemsPerPage)
            ->setConfig(clone $defaultPaginationConfigBuilder->getPaginationConfigTransfer());

        return $paginationSearchResultTransfer;
    }
}

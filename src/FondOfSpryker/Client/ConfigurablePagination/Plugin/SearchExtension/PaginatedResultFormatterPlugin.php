<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\SearchExtension;

use Elastica\ResultSet;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory getFactory()
 */
class PaginatedResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    public const NAME = 'pagination';

    protected const AGGREGATION_NAME_TOTAL_COLLAPSED_HITS = 'total_collapsed_hits';
    protected const TOTAL_COLLAPSED_HITS_VALUE = 'value';

    /**
     * {@inheritDoc}
     *
     * @api
     *
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
        $paginationConfig = $this->getFactory()->createPaginationConfigBuilder()->build();

        $totalHits = $this->getTotalHitsBySearchResult($searchResult);
        $itemsPerPage = $paginationConfig->getCurrentItemsPerPage($requestParameters);
        $maxPage = (int)ceil($totalHits / $itemsPerPage);
        $currentPage = min($paginationConfig->getCurrentPage($requestParameters), $maxPage);

        return (new PaginationSearchResultTransfer())
            ->setNumFound($totalHits)
            ->setCurrentPage($currentPage)
            ->setMaxPage($maxPage)
            ->setCurrentItemsPerPage($itemsPerPage)
            ->setConfig(clone $paginationConfig->get());
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     *
     * @return int
     */
    protected function getTotalHitsBySearchResult(ResultSet $searchResult): int
    {
        $aggregations = $searchResult->getAggregations();

        if (!isset($aggregations[static::AGGREGATION_NAME_TOTAL_COLLAPSED_HITS][static::TOTAL_COLLAPSED_HITS_VALUE])) {
            return $searchResult->getTotalHits();
        }

        return $aggregations[static::AGGREGATION_NAME_TOTAL_COLLAPSED_HITS][static::TOTAL_COLLAPSED_HITS_VALUE];
    }
}

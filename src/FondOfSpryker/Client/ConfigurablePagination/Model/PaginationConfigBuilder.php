<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Model;

use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig;
use FondOfSpryker\Shared\ConfigurablePagination\ConfigurablePaginationConstants;
use Generated\Shared\Transfer\PaginationConfigTransfer;

class PaginationConfigBuilder implements PaginationConfigBuilderInterface
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig $config
     */
    public function __construct(ConfigurablePaginationConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface
     */
    public function build(): PaginationConfigInterface
    {
        $paginationConfigTransfer = (new PaginationConfigTransfer())
            ->setParameterName(ConfigurablePaginationConstants::PAGINATION_PARAMETER_NAME_PAGE)
            ->setItemsPerPageParameterName(ConfigurablePaginationConstants::PAGINATION_PARAMETER_NAME_ITEMS_PER_PAGE)
            ->setDefaultItemsPerPage($this->config->getItemsPerPage())
            ->setValidItemsPerPageOptions($this->config->getValidItemsPerPageOptions());

        $paginationConfig = new PaginationConfig();

        $paginationConfig->setPagination($paginationConfigTransfer);

        return $paginationConfig;
    }
}

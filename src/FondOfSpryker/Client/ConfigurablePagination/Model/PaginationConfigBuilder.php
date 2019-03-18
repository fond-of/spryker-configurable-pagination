<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Model;

use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig;
use FondOfSpryker\Client\ConfigurablePagination\Plugin\Config\CatalogSearchConfigBuilder;
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
     * @return \Generated\Shared\Transfer\PaginationConfigTransfer
     */
    public function build(): PaginationConfigTransfer
    {
        $paginationConfig = new PaginationConfigTransfer();

        $paginationConfig->setParameterName(CatalogSearchConfigBuilder::PARAMETER_NAME_PAGE)
            ->setItemsPerPageParameterName(CatalogSearchConfigBuilder::PARAMETER_NAME_ITEMS_PER_PAGE)
            ->setDefaultItemsPerPage($this->config->getItemsPerPage())
            ->setValidItemsPerPageOptions($this->config->getValidItemsPerPageOptions());

        return $paginationConfig;
    }
}

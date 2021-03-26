<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilder;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface;
use Spryker\Client\Kernel\AbstractFactory;

/**
 * @method \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig getConfig()
 */
class ConfigurablePaginationFactory extends AbstractFactory
{
    /**
     * @return \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface
     */
    public function createPaginationConfigBuilder(): PaginationConfigBuilderInterface
    {
        return new PaginationConfigBuilder($this->getConfig());
    }
}

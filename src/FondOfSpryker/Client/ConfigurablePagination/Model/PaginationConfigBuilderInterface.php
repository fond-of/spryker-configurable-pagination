<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Model;

interface PaginationConfigBuilderInterface
{
    /**
     * @return \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface
     */
    public function build(): PaginationConfigInterface;
}

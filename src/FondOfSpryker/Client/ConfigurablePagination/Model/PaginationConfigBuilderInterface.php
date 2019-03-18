<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Model;

use Generated\Shared\Transfer\PaginationConfigTransfer;

interface PaginationConfigBuilderInterface
{
    /**
     * @return \Generated\Shared\Transfer\PaginationConfigTransfer
     */
    public function build(): PaginationConfigTransfer;
}

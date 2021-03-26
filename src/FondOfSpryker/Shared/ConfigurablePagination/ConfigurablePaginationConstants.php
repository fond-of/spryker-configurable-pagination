<?php

namespace FondOfSpryker\Shared\ConfigurablePagination;

interface ConfigurablePaginationConstants
{
    public const PAGINATION_PARAMETER_NAME_PAGE = 'page';
    public const PAGINATION_PARAMETER_NAME_ITEMS_PER_PAGE = 'ipp';

    public const ITEMS_PER_PAGE = 'FOND_OF_SPRYKER:CONFIGURABLE_PAGINATION:ITEMS_PER_PAGE';
    public const DEFAULT_ITEMS_PER_PAGE = 12;

    public const VALID_ITEMS_PER_PAGE_OPTIONS = 'FOND_OF_SPRYKER:CONFIGURABLE_PAGINATION:VALID_ITEMS_PER_PAGE_OPTIONS';
    public const DEFAULT_VALID_ITEMS_PER_PAGE_OPTIONS = [12, 24, 36];
}

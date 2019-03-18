<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use Spryker\Client\Kernel\AbstractBundleConfig;

class ConfigurablePaginationConfig extends AbstractBundleConfig
{
    public const ITEMS_PER_PAGE = 'FOND_OF_SPRYKER:CONFIGURABLE_PAGINATION:ITEMS_PER_PAGE';
    public const DEFAULT_ITEMS_PER_PAGE = 12;

    public const VALID_ITEMS_PER_PAGE_OPTIONS = 'FOND_OF_SPRYKER:CONFIGURABLE_PAGINATION:VALID_ITEMS_PER_PAGE_OPTIONS';
    public const DEFAULT_VALID_ITEMS_PER_PAGE_OPTIONS = [12, 24, 36];

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->get(static::ITEMS_PER_PAGE, static::DEFAULT_ITEMS_PER_PAGE);
    }

    /**
     * @return array
     */
    public function getValidItemsPerPageOptions(): array
    {
        return $this->get(static::VALID_ITEMS_PER_PAGE_OPTIONS, static::DEFAULT_VALID_ITEMS_PER_PAGE_OPTIONS);
    }
}

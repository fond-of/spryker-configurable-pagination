<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use FondOfSpryker\Shared\ConfigurablePagination\ConfigurablePaginationConstants;
use Spryker\Client\Kernel\AbstractBundleConfig;

class ConfigurablePaginationConfig extends AbstractBundleConfig
{
    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->get(ConfigurablePaginationConstants::ITEMS_PER_PAGE, ConfigurablePaginationConstants::DEFAULT_ITEMS_PER_PAGE);
    }

    /**
     * @return array
     */
    public function getValidItemsPerPageOptions(): array
    {
        return $this->get(ConfigurablePaginationConstants::VALID_ITEMS_PER_PAGE_OPTIONS, ConfigurablePaginationConstants::DEFAULT_VALID_ITEMS_PER_PAGE_OPTIONS);
    }
}

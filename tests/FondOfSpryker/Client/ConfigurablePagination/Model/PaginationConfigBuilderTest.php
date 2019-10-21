<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig;
use Generated\Shared\Transfer\PaginationConfigTransfer;

class PaginationConfigBuilderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilder
     */
    protected $paginationConfigBuilder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig
     */
    protected $configurablePaginationConfigMock;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * @var array
     */
    protected $validItemsPerPageOptions;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configurablePaginationConfigMock = $this->getMockBuilder(ConfigurablePaginationConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemsPerPage = 1;

        $this->validItemsPerPageOptions = [1, 10, 50];

        $this->paginationConfigBuilder = new PaginationConfigBuilder($this->configurablePaginationConfigMock);
    }

    /**
     * @return void
     */
    public function testBuild(): void
    {
        $this->configurablePaginationConfigMock->expects($this->atLeastOnce())
            ->method('getItemsPerPage')
            ->willReturn($this->itemsPerPage);

        $this->configurablePaginationConfigMock->expects($this->atLeastOnce())
            ->method('getValidItemsPerPageOptions')
            ->willReturn($this->validItemsPerPageOptions);

        $this->assertInstanceOf(PaginationConfigTransfer::class, $this->paginationConfigBuilder->build());
    }
}

<?php

namespace FondOfSpryker\Client\Config;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PaginationConfigTransfer;

class DefaultPaginationConfigBuilderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder
     */
    protected $defaultPaginationConfigBuilder;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationConfigTransfer
     */
    protected $paginationConfigTransferMock;

    /**
     * @var string
     */
    protected $paramName;

    /**
     * @var array
     */
    protected $requestParameters;

    /**
     * @var array
     */
    protected $requestParametersDefault;

    /**
     * @var string
     */
    protected $itemsPerPageParameterName;

    /**
     * @var array
     */
    private $validItemsPerPageOptions;

    /**
     * @var int
     */
    protected $defaultItemsPerPage;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->paginationConfigTransferMock = $this->getMockBuilder(PaginationConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paramName = "param-name";

        $this->itemsPerPageParameterName = "items-per-page-parameter-name";

        $this->requestParameters = [
            $this->paramName => 1,
            $this->itemsPerPageParameterName => 1,
        ];

        $this->requestParametersDefault = [
            $this->itemsPerPageParameterName => 12,
        ];

        $this->defaultItemsPerPage = 1;

        $this->validItemsPerPageOptions = [1, 10, 50];

        $this->defaultPaginationConfigBuilder = new DefaultPaginationConfigBuilder();
    }

    /**
     * @return void
     */
    public function testPaginationConfigTransfer(): void
    {
        $this->defaultPaginationConfigBuilder->setPaginationConfigTransfer($this->paginationConfigTransferMock);

        $this->assertInstanceOf(PaginationConfigTransfer::class, $this->defaultPaginationConfigBuilder->getPaginationConfigTransfer());
    }

    /**
     * @depends testPaginationConfigTransfer
     *
     * @return void
     */
    public function testGetCurrentPage(): void
    {
        $this->defaultPaginationConfigBuilder->setPaginationConfigTransfer($this->paginationConfigTransferMock);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('requireParameterName')
            ->willReturn($this->paginationConfigTransferMock);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getParameterName')
            ->willReturn($this->paramName);

        $this->assertSame(1, $this->defaultPaginationConfigBuilder->getCurrentPage($this->requestParameters));
    }

    /**
     * @return void
     */
    public function testGetCurrentItemsPerPage(): void
    {
        $this->defaultPaginationConfigBuilder->setPaginationConfigTransfer($this->paginationConfigTransferMock);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getItemsPerPageParameterName')
            ->willReturn($this->itemsPerPageParameterName);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getValidItemsPerPageOptions')
            ->willReturn($this->validItemsPerPageOptions);

        $this->assertSame(1, $this->defaultPaginationConfigBuilder->getCurrentItemsPerPage($this->requestParameters));
    }

    /**
     * @return void
     */
    public function testGetCurrentItemsPerPageDefault(): void
    {
        $this->defaultPaginationConfigBuilder->setPaginationConfigTransfer($this->paginationConfigTransferMock);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getItemsPerPageParameterName')
            ->willReturn($this->itemsPerPageParameterName);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getValidItemsPerPageOptions')
            ->willReturn($this->validItemsPerPageOptions);

        $this->paginationConfigTransferMock->expects($this->atLeastOnce())
            ->method('getDefaultItemsPerPage')
            ->willReturn($this->defaultItemsPerPage);

        $this->assertSame(1, $this->defaultPaginationConfigBuilder->getCurrentItemsPerPage($this->requestParametersDefault));
    }
}

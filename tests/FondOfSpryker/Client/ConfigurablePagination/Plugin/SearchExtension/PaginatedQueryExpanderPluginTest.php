<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class PaginatedQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Plugin\SearchExtension\PaginatedQueryExpanderPlugin
     */
    protected $paginatedQueryExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory
     */
    protected $configurablePaginationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface
     */
    protected $paginationConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface
     */
    protected $paginationConfigBuilderMock;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $currentItemsPerPage;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configurablePaginationFactoryMock = $this->getMockBuilder(ConfigurablePaginationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigBuilderMock = $this->getMockBuilder(PaginationConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigMock = $this->getMockBuilder(PaginationConfigInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currentPage = 1;

        $this->currentItemsPerPage = 10;

        $this->paginatedQueryExpanderPlugin = new PaginatedQueryExpanderPlugin();
        $this->paginatedQueryExpanderPlugin->setFactory($this->configurablePaginationFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->configurablePaginationFactoryMock->expects($this->atLeastOnce())
            ->method('createPaginationConfigBuilder')
            ->willReturn($this->paginationConfigBuilderMock);

        $this->paginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('build')
            ->willReturn($this->paginationConfigMock);

        $this->paginationConfigMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturn($this->currentPage);

        $this->paginationConfigMock->expects($this->atLeastOnce())
            ->method('getCurrentItemsPerPage')
            ->willReturn($this->currentItemsPerPage);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->paginatedQueryExpanderPlugin->expandQuery($this->queryInterfaceMock)
        );
    }
}

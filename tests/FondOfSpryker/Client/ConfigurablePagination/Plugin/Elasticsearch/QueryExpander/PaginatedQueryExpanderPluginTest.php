<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Elasticsearch\QueryExpander;

use Codeception\Test\Unit;
use Elastica\Query;
use FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class PaginatedQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Plugin\Elasticsearch\QueryExpander\PaginatedQueryExpanderPlugin
     */
    protected $paginatedQueryExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory
     */
    protected $configurablePaginationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder
     */
    protected $defaultPaginationConfigBuilderMock;

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

        $this->defaultPaginationConfigBuilderMock = $this->getMockBuilder(DefaultPaginationConfigBuilder::class)
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
            ->method('createDefaultPaginationConfigBuilder')
            ->willReturn($this->defaultPaginationConfigBuilderMock);

        $this->defaultPaginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturn($this->currentPage);

        $this->defaultPaginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('getCurrentItemsPerPage')
            ->willReturn($this->currentItemsPerPage);

        $this->assertInstanceOf(QueryInterface::class, $this->paginatedQueryExpanderPlugin->expandQuery($this->queryInterfaceMock));
    }
}

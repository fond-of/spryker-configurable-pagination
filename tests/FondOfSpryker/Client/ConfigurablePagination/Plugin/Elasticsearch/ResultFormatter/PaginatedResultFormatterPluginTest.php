<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Elasticsearch\ResultFormatter;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory;
use Generated\Shared\Transfer\PaginationConfigTransfer;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use ReflectionClass;
use ReflectionMethod;

class PaginatedResultFormatterPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Plugin\Elasticsearch\ResultFormatter\PaginatedResultFormatterPlugin
     */
    protected $paginatedResultFormatterPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    protected $resultSetMock;

    /**
     * @var array
     */
    protected $requestParameters;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory
     */
    protected $configurablePaginationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\Config\DefaultPaginationConfigBuilder
     */
    protected $defaultPaginationConfigBuilderMock;

    /**
     * @var int
     */
    protected $currentItemsPerPage;

    /**
     * @var int
     */
    protected $totalHits;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationConfigTransfer
     */
    protected $paginationConfigTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configurablePaginationFactoryMock = $this->getMockBuilder(ConfigurablePaginationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->defaultPaginationConfigBuilderMock = $this->getMockBuilder(DefaultPaginationConfigBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigTransferMock = $this->getMockBuilder(PaginationConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->requestParameters = [];

        $this->currentItemsPerPage = 10;

        $this->totalHits = 44;

        $this->currentPage = 1;

        $this->paginatedResultFormatterPlugin = new PaginatedResultFormatterPlugin();
        $this->paginatedResultFormatterPlugin->setFactory($this->configurablePaginationFactoryMock);
    }

    /**
     * @return void
     */
    public function testGetName(): void
    {
        $this->assertSame('pagination', $this->paginatedResultFormatterPlugin->getName());
    }

    /**
     * @return void
     */
    public function testFormatSearchResult(): void
    {
        $reflectionMethod = $this->getReflectionMethodByName('formatSearchResult');

        $this->configurablePaginationFactoryMock->expects($this->atLeastOnce())
            ->method('createDefaultPaginationConfigBuilder')
            ->willReturn($this->defaultPaginationConfigBuilderMock);

        $this->defaultPaginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('getCurrentItemsPerPage')
            ->willReturn($this->currentItemsPerPage);

        $this->resultSetMock->expects($this->atLeast(2))
            ->method('getTotalHits')
            ->willReturn($this->totalHits);

        $this->defaultPaginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturn($this->currentPage);

        $this->defaultPaginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('getPaginationConfigTransfer')
            ->willReturn($this->paginationConfigTransferMock);

        $this->assertInstanceOf(PaginationSearchResultTransfer::class, $reflectionMethod->invokeArgs($this->paginatedResultFormatterPlugin, [$this->resultSetMock, $this->requestParameters]));
    }

    /**
     * @param string $name
     *
     * @return \ReflectionMethod
     */
    protected function getReflectionMethodByName(string $name): ReflectionMethod
    {
        $reflectionClass = new ReflectionClass(PaginatedResultFormatterPlugin::class);

        $reflectionMethod = $reflectionClass->getMethod($name);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }
}

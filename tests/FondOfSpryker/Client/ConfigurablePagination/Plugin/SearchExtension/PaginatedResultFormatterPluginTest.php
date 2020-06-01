<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface;
use Generated\Shared\Transfer\PaginationConfigTransfer;
use Generated\Shared\Transfer\PaginationSearchResultTransfer;
use ReflectionClass;
use ReflectionMethod;

class PaginatedResultFormatterPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Plugin\SearchExtension\PaginatedResultFormatterPlugin
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface
     */
    protected $paginationConfigBuilderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigInterface
     */
    protected $paginationConfigMock;

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

        $this->paginationConfigBuilderMock = $this->getMockBuilder(PaginationConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigMock = $this->getMockBuilder(PaginationConfigInterface::class)
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
            ->method('createPaginationConfigBuilder')
            ->willReturn($this->paginationConfigBuilderMock);

        $this->paginationConfigBuilderMock->expects($this->atLeastOnce())
            ->method('build')
            ->willReturn($this->paginationConfigMock);

        $this->paginationConfigMock->expects($this->atLeastOnce())
            ->method('getCurrentItemsPerPage')
            ->willReturn($this->currentItemsPerPage);

        $this->resultSetMock->expects($this->atLeast(2))
            ->method('getTotalHits')
            ->willReturn($this->totalHits);

        $this->paginationConfigMock->expects($this->atLeastOnce())
            ->method('getCurrentPage')
            ->willReturn($this->currentPage);

        $this->paginationConfigMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->paginationConfigTransferMock);

        $this->assertInstanceOf(
            PaginationSearchResultTransfer::class,
            $reflectionMethod->invokeArgs($this->paginatedResultFormatterPlugin, [$this->resultSetMock, $this->requestParameters])
        );
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

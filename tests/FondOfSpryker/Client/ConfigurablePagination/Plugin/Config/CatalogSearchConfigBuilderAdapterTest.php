<?php

namespace FondOfSpryker\Client\ConfigurablePagination\Plugin\Config;

use Codeception\Test\Unit;
use FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface as ModelPaginationConfigBuilderInterface;
use Generated\Shared\Transfer\PaginationConfigTransfer;
use Spryker\Client\Search\Dependency\Plugin\FacetConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface;
use Spryker\Client\Search\Dependency\Plugin\SortConfigBuilderInterface;

class CatalogSearchConfigBuilderAdapterTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\Plugin\Config\CatalogSearchConfigBuilderAdapter
     */
    protected $catalogSearchConfigBuilderAdapter;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\SearchConfigBuilderInterface
     */
    protected $searchConfigBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory
     */
    protected $configurablePaginationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\FacetConfigBuilderInterface
     */
    protected $facetConfigBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\SortConfigBuilderInterface
     */
    protected $sortConfigBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\PaginationConfigBuilderInterface
     */
    protected $paginationConfigBuilderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PaginationConfigTransfer
     */
    protected $paginationConfigTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $paginationConfigBuilderInterfaceModelMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configurablePaginationFactoryMock = $this->getMockBuilder(ConfigurablePaginationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchConfigBuilderInterfaceMock = $this->getMockBuilder(SearchConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facetConfigBuilderInterfaceMock = $this->getMockBuilder(FacetConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sortConfigBuilderInterfaceMock = $this->getMockBuilder(SortConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigBuilderInterfaceMock = $this->getMockBuilder(PaginationConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigTransferMock = $this->getMockBuilder(PaginationConfigTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->paginationConfigBuilderInterfaceModelMock = $this->getMockBuilder(ModelPaginationConfigBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->catalogSearchConfigBuilderAdapter = new CatalogSearchConfigBuilderAdapter($this->searchConfigBuilderInterfaceMock);
        $this->catalogSearchConfigBuilderAdapter->setFactory($this->configurablePaginationFactoryMock);
    }

    /**
     * @return void
     */
    public function testBuildFacetConfig(): void
    {
        $this->catalogSearchConfigBuilderAdapter->buildFacetConfig($this->facetConfigBuilderInterfaceMock);
    }

    /**
     * @return void
     */
    public function testSortConfig(): void
    {
        $this->catalogSearchConfigBuilderAdapter->buildSortConfig($this->sortConfigBuilderInterfaceMock);
    }

    /**
     * @return void
     */
    public function testBuildPaginationConfig(): void
    {
        $this->configurablePaginationFactoryMock->expects($this->atLeastOnce())
            ->method('createPaginationConfigBuilder')
            ->willReturn($this->paginationConfigBuilderInterfaceModelMock);

        $this->paginationConfigBuilderInterfaceModelMock->expects($this->atLeastOnce())
            ->method('build')
            ->willReturn($this->paginationConfigTransferMock);

        $this->catalogSearchConfigBuilderAdapter->buildPaginationConfig($this->paginationConfigBuilderInterfaceMock);
    }
}

<?php

namespace FondOfSpryker\Client\ConfigurablePagination;

use Codeception\Test\Unit;
use FondOfSpryker\Client\Config\DefaultPaginationConfigBuilderInterface;
use FondOfSpryker\Client\ConfigurablePagination\Model\PaginationConfigBuilderInterface;

class ConfigurablePaginationFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationFactory
     */
    protected $configurablePaginationFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\ConfigurablePagination\ConfigurablePaginationConfig
     */
    protected $configurablePaginationConfigMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->configurablePaginationConfigMock = $this->getMockBuilder(ConfigurablePaginationConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configurablePaginationFactoryMock = new ConfigurablePaginationFactory();
        $this->configurablePaginationFactoryMock->setConfig($this->configurablePaginationConfigMock);
    }

    /**
     * @return void
     */
    public function testCreatePaginationConfigBuilder(): void
    {
        $this->assertInstanceOf(PaginationConfigBuilderInterface::class, $this->configurablePaginationFactoryMock->createPaginationConfigBuilder());
    }

    /**
     * @return void
     */
    public function testCreateDefaultPaginationConfigBuilder(): void
    {
        $this->assertInstanceOf(DefaultPaginationConfigBuilderInterface::class, $this->configurablePaginationFactoryMock->createDefaultPaginationConfigBuilder());
    }
}

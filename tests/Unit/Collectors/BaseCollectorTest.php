<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit\Collectors;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\BaseCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class BaseCollectorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCollectorReceivesStatusGetter(): void
    {
        $statusGetter = Mockery::mock(StatusGetter::class);

        $collector = $this->createConcreteCollector($statusGetter);

        $this->assertInstanceOf(BaseCollector::class, $collector);
    }

    public function testStatusMethodDelegatestoStatusGetter(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with('pool', null)
            ->once()
            ->andReturn('www');

        $collector = $this->createConcreteCollector($statusGetter);

        $reflection = new \ReflectionClass($collector);
        $method = $reflection->getMethod('status');
        if (PHP_VERSION_ID < 80100) {
            $method->setAccessible(true);
        }

        $result = $method->invoke($collector, 'pool');

        $this->assertEquals('www', $result);
    }

    protected function createConcreteCollector(StatusGetter $statusGetter): BaseCollector
    {
        return new class($statusGetter) extends BaseCollector {
            public function register(Prometheus $prometheus): void
            {
                // Empty implementation for testing
            }
        };
    }
}

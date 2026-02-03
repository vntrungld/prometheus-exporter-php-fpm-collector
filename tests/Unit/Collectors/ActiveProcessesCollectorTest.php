<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit\Collectors;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ActiveProcessesCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class ActiveProcessesCollectorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRegisterCreatesGaugeWithCorrectValues(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with('active-processes', null)
            ->andReturn(5);
        $statusGetter->shouldReceive('getStatus')
            ->with('pool', null)
            ->andReturn('www');

        /** @var MockInterface|Gauge $gauge */
        $gauge = Mockery::mock(Gauge::class);
        $gauge->shouldReceive('help')->andReturnSelf();
        $gauge->shouldReceive('labels')->with(['pool'])->andReturnSelf();
        $gauge->shouldReceive('value')->with(5, ['www'])->andReturnSelf();

        /** @var MockInterface|Prometheus $prometheus */
        $prometheus = Mockery::mock(Prometheus::class);
        $prometheus->shouldReceive('addGauge')
            ->with('fpm_active_processes')
            ->once()
            ->andReturn($gauge);

        $collector = new ActiveProcessesCollector($statusGetter);
        $collector->register($prometheus);

        $this->assertTrue(true);
    }
}

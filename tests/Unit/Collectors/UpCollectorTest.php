<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit\Collectors;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\UpCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class UpCollectorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRegisterCreatesGaugeWithCorrectName(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with(null, null)
            ->andReturn(['pool' => 'www']);
        $statusGetter->shouldReceive('getStatus')
            ->with('pool', null)
            ->andReturn('www');

        /** @var MockInterface|Gauge $gauge */
        $gauge = Mockery::mock(Gauge::class);
        $gauge->shouldReceive('help')->andReturnSelf();
        $gauge->shouldReceive('labels')->with(['pool'])->andReturnSelf();
        $gauge->shouldReceive('value')->with(true, ['www'])->andReturnSelf();

        /** @var MockInterface|Prometheus $prometheus */
        $prometheus = Mockery::mock(Prometheus::class);
        $prometheus->shouldReceive('addGauge')
            ->with('fpm_up')
            ->once()
            ->andReturn($gauge);

        $collector = new UpCollector($statusGetter);
        $collector->register($prometheus);

        $this->assertTrue(true);
    }

    public function testRegisterReportsDownWhenStatusIsFalse(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with(null, null)
            ->andReturn(false);
        $statusGetter->shouldReceive('getStatus')
            ->with('pool', null)
            ->andReturn(null);

        /** @var MockInterface|Gauge $gauge */
        $gauge = Mockery::mock(Gauge::class);
        $gauge->shouldReceive('help')->andReturnSelf();
        $gauge->shouldReceive('labels')->with(['pool'])->andReturnSelf();
        $gauge->shouldReceive('value')->with(false, [null])->andReturnSelf();

        /** @var MockInterface|Prometheus $prometheus */
        $prometheus = Mockery::mock(Prometheus::class);
        $prometheus->shouldReceive('addGauge')
            ->with('fpm_up')
            ->once()
            ->andReturn($gauge);

        $collector = new UpCollector($statusGetter);
        $collector->register($prometheus);

        $this->assertTrue(true);
    }
}

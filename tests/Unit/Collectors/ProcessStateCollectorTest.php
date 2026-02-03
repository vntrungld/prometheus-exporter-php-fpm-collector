<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit\Collectors;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporter\Prometheus;
use Vntrungld\PrometheusExporter\MetricTypes\Gauge;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessStateCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class ProcessStateCollectorTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testRegisterCreatesGaugesForEachProcessAndState(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with('procs', [])
            ->andReturn([
                0 => ['state' => 'Idle'],
                1 => ['state' => 'Running'],
            ]);
        $statusGetter->shouldReceive('getStatus')
            ->with('pool', null)
            ->andReturn('www');

        /** @var MockInterface|Gauge $gauge */
        $gauge = Mockery::mock(Gauge::class);
        $gauge->shouldReceive('help')->andReturnSelf();
        $gauge->shouldReceive('labels')
            ->with(['pool', 'child', 'state'])
            ->andReturnSelf();
        $gauge->shouldReceive('value')->andReturnSelf();

        /** @var MockInterface|Prometheus $prometheus */
        $prometheus = Mockery::mock(Prometheus::class);
        // 2 processes * 6 states = 12 gauge calls
        $prometheus->shouldReceive('addGauge')
            ->with('fpm_process_state')
            ->times(12)
            ->andReturn($gauge);

        $collector = new ProcessStateCollector($statusGetter);
        $collector->register($prometheus);

        $this->assertTrue(true);
    }

    public function testRegisterHandlesEmptyProcessList(): void
    {
        /** @var MockInterface|StatusGetter $statusGetter */
        $statusGetter = Mockery::mock(StatusGetter::class);
        $statusGetter->shouldReceive('getStatus')
            ->with('procs', [])
            ->andReturn([]);

        /** @var MockInterface|Prometheus $prometheus */
        $prometheus = Mockery::mock(Prometheus::class);
        $prometheus->shouldNotReceive('addGauge');

        $collector = new ProcessStateCollector($statusGetter);
        $collector->register($prometheus);

        $this->assertTrue(true);
    }
}

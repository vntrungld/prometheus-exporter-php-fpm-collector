<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporterPhpFpmCollector\PhpFpmCollectorSet;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\UpCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\AcceptedConnectionsCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ActiveProcessesCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\IdleProcessesCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ListenQueueCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ListenQueueLengthCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxActiveProcessesCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxChildrenReachedCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxListenQueueCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\SlowRequestsCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\StartSinceCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\TotalProcessesCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessLastRequestCpuCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessLastRequestMemoryCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestDurationCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestLengthCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestsCollector;
use Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessStateCollector;

class PhpFpmCollectorSetTest extends TestCase
{
    protected PhpFpmCollectorSet $collectorSet;

    protected function setUp(): void
    {
        parent::setUp();
        $this->collectorSet = new PhpFpmCollectorSet();
    }

    public function testCollectorsReturnsArray(): void
    {
        $collectors = $this->collectorSet->collectors();

        $this->assertIsArray($collectors);
    }

    public function testCollectorsReturnsExpectedNumberOfCollectors(): void
    {
        $collectors = $this->collectorSet->collectors();

        $this->assertCount(18, $collectors);
    }

    public function testCollectorsContainsAllExpectedCollectors(): void
    {
        $collectors = $this->collectorSet->collectors();

        $expectedCollectors = [
            UpCollector::class,
            AcceptedConnectionsCollector::class,
            ActiveProcessesCollector::class,
            IdleProcessesCollector::class,
            ListenQueueCollector::class,
            ListenQueueLengthCollector::class,
            MaxActiveProcessesCollector::class,
            MaxChildrenReachedCollector::class,
            MaxListenQueueCollector::class,
            SlowRequestsCollector::class,
            StartSinceCollector::class,
            TotalProcessesCollector::class,
            ProcessLastRequestCpuCollector::class,
            ProcessLastRequestMemoryCollector::class,
            ProcessRequestDurationCollector::class,
            ProcessRequestLengthCollector::class,
            ProcessRequestsCollector::class,
            ProcessStateCollector::class,
        ];

        foreach ($expectedCollectors as $expectedCollector) {
            $this->assertContains($expectedCollector, $collectors);
        }
    }

    public function testAllCollectorClassesExist(): void
    {
        $collectors = $this->collectorSet->collectors();

        foreach ($collectors as $collector) {
            $this->assertTrue(class_exists($collector), "Class {$collector} does not exist");
        }
    }
}

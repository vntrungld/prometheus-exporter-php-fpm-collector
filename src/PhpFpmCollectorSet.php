<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector;

use Vntrungld\PrometheusExporter\Collectors\CollectorSet;

class PhpFpmCollectorSet implements CollectorSet
{
    /**
     * @inheritDoc
     */
    public function collectors(): array
    {
        return [
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\UpCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\AcceptedConnectionsCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ActiveProcessesCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\IdleProcessesCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ListenQueueCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ListenQueueLengthCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxActiveProcessesCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxChildrenReachedCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\MaxListenQueueCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\SlowRequestsCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\StartSinceCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\TotalProcessesCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessLastRequestCpuCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessLastRequestMemoryCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestDurationCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestLengthCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessRequestsCollector::class,
            \Vntrungld\PrometheusExporterPhpFpmCollector\Collectors\ProcessStateCollector::class,
        ];
    }
}

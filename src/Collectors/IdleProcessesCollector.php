<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class IdleProcessesCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addGauge('fpm_idle_processes')
            ->help('The number of idle processes.')
            ->value($status['idle-processes']);
    }
}

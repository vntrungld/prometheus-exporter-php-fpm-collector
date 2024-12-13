<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class IdleProcessesCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('fpm_idle_processes')
            ->help('The number of idle processes.')
            ->labels(['pool'])
            ->value($this->status('idle-processes'), [$this->status('pool')]);
    }
}

<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class TotalProcessesCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_total_processes')
            ->help('The number of idle + active processes.')
            ->labels(['pool'])
            ->value($this->status('total-processes'), [$this->status('pool')]);
    }
}

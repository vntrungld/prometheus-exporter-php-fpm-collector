<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class MaxActiveProcessesCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_max_active_processes')
            ->help('The maximum number of active processes since FPM has started.')
            ->labels(['pool'])
            ->value($this->status('max-active-processes'), [$this->status('pool')]);
    }
}

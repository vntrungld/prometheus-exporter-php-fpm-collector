<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class StartSinceCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_start_since')
            ->help('The number of seconds since FPM has started.')
            ->labels(['pool'])
            ->value($this->status('start-since'), [$this->status('pool')]);
    }
}

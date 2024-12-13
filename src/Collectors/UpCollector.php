<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class UpCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $up = (bool) $this->status();

        $prometheus->addGauge('fpm_up')
            ->help('The number of active processes.')
            ->labels(['pool'])
            ->value($up, [$this->status('pool')]);
    }
}

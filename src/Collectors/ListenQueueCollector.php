<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ListenQueueCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('fpm_listen_queue')
            ->help('The number of requests in the queue of pending connections.')
            ->labels(['pool'])
            ->value($this->status('listen-queue'), [$this->status('pool')]);
    }
}

<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class ListenQueueCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addGauge('fpm_listen_queue')
            ->help('The number of requests in the queue of pending connections.')
            ->value($status['listen-queue']);
    }
}

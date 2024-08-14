<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class SlowRequestsCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addCounter('fpm_slow_requests')
            ->help('The number of requests that exceeded your request_slowlog_timeout value.')
            ->value($status['slow-requests']);
    }
}

<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class SlowRequestsCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_slow_requests')
            ->help('The number of requests that exceeded your request_slowlog_timeout value.')
            ->labels(['pool'])
            ->value($this->status('slow-requests'), [$this->status('pool')]);
    }
}

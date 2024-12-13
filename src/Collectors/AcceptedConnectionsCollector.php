<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class AcceptedConnectionsCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_accepted_connections')
            ->help('The number of requests accepted by the pool.')
            ->labels(['pool'])
            ->value($this->status('accepted-conn'), [$this->status('pool')]);
    }
}

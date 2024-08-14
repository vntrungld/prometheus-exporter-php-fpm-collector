<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporter\Prometheus;

class MaxChildrenReachedCollector implements Collector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $status = fpm_get_status();

        $prometheus->addCounter('fpm_max_children_reached')
            ->help('The number of times the process limit has been reached.')
            ->value($status['max-children-reached']);
    }
}

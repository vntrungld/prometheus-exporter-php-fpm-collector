<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class MaxChildrenReachedCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_max_children_reached')
            ->help('The number of times the process limit has been reached.')
            ->labels(['pool'])
            ->value($this->status('max-children-reached'), [$this->status('pool')]);
    }
}

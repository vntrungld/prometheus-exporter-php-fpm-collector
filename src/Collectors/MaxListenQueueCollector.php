<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class MaxListenQueueCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addCounter('fpm_max_listen_queue')
            ->help('The maximum number of requests in the queue of pending connections since FPM has started.')
            ->labels(['pool'])
            ->value($this->status('max-listen-queue'), [$this->status('pool')]);
    }
}

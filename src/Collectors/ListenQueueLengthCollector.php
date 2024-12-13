<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ListenQueueLengthCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $prometheus->addGauge('fpm_listen_queue_length')
            ->help('The size of the socket queue of pending connections.')
            ->labels(['pool'])
            ->value($this->status('listen-queue-len'), [$this->status('pool')]);
    }
}

<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessRequestsCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $prometheus->addGauge('fpm_process_requests')
                ->help('The number of requests the process has served.')
                ->labels([
                    'pool',
                    'child',
                ])
                ->value($process['requests'], [
                    $this->status('pool'),
                    $child,
                ]);
        }
    }
}

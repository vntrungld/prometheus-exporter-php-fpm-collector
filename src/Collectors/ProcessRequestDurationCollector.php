<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessRequestDurationCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $prometheus->addGauge('fpm_process_request_duration')
                ->help('The request duration in seconds.')
                ->labels([
                    'pool',
                    'child',
                ])
                ->value($process['request-duration'], [
                    $this->status('pool'),
                    $child,
                ]);
        }
    }
}

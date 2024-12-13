<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessLastRequestMemoryCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $prometheus->addGauge('fpm_process_last_request_memory')
                ->help('The memory usage in bytes for the last request.')
                ->labels([
                    'pool',
                    'child',
                ])
                ->value($process['last-request-memory'], [
                    $this->status('pool'),
                    $child,
                ]);
        }
    }
}

<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessLastRequestCpuCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $prometheus->addGauge('fpm_process_last_request_cpu')
                ->help('The CPU usage in seconds for the last request.')
                ->labels([
                    'pool',
                    'child',
                ])
                ->value($process['last-request-cpu'], [
                   $this->status('pool'),
                   $child,
                ]);
        }
    }
}

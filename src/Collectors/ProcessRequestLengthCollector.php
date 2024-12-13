<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessRequestLengthCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $prometheus->addGauge('fpm_process_request_length')
                ->help('The request length of the process.')
                ->labels([
                    'pool',
                    'child',
                ])
                ->value($process['request-length'], [
                    $this->status('pool'),
                    $child
                ]);
        }

    }
}

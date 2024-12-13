<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Prometheus;

class ProcessStateCollector extends BaseCollector
{
    /**
     * @inheritDoc
     */
    public function register(Prometheus $prometheus): void
    {
        $processes = $this->status('procs', []);

        foreach ($processes as $child => $process) {
            $states = [
                'Idle' => 0,
                'Getting request informations' => 0,
                'Reading headers' => 0,
                'Running' => 0,
                'Ending' => 0,
                'Finishing' => 0,
            ];

            $states[$process['state']] = 1;

            foreach ($states as $state => $count) {
                $prometheus->addGauge('fpm_process_state')
                    ->help('The number of active processes.')
                    ->labels([
                        'pool',
                        'child',
                        'state',
                    ])
                    ->value($count, [
                        $this->status('pool'),
                        $child,
                        $state,
                    ]);
            }
        }
    }
}

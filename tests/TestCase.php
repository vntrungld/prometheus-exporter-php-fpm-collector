<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Vntrungld\PrometheusExporterPhpFpmCollector\PrometheusExporterPhpFpmCollectorServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PrometheusExporterPhpFpmCollectorServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        //
    }
}

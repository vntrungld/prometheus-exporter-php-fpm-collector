<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit;

use Vntrungld\PrometheusExporterPhpFpmCollector\Tests\TestCase;
use Vntrungld\PrometheusExporterPhpFpmCollector\PrometheusExporterPhpFpmCollectorServiceProvider;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class ServiceProviderTest extends TestCase
{
    public function testServiceProviderIsRegistered(): void
    {
        $providers = $this->app->getLoadedProviders();

        $this->assertArrayHasKey(
            PrometheusExporterPhpFpmCollectorServiceProvider::class,
            $providers
        );
    }

    public function testStatusGetterIsBoundAsSingleton(): void
    {
        // Skip this test if fpm_get_status is not available (running outside of PHP-FPM)
        if (!function_exists('fpm_get_status')) {
            $this->markTestSkipped('fpm_get_status() is not available outside of PHP-FPM');
        }

        $instance1 = $this->app->make('prometheus-exporter-php-fpm-status-getter');
        $instance2 = $this->app->make('prometheus-exporter-php-fpm-status-getter');

        $this->assertSame($instance1, $instance2);
    }

    public function testProvidesReturnsExpectedServices(): void
    {
        $provider = new PrometheusExporterPhpFpmCollectorServiceProvider($this->app);

        $provides = $provider->provides();

        $this->assertContains('prometheus-exporter-php-fpm-collector', $provides);
    }
}

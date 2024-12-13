<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Collectors;

use Vntrungld\PrometheusExporter\Collectors\Collector;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

abstract class BaseCollector implements Collector
{
    /**
     * @var StatusGetter
     */
    protected $getter;

    /**
     * BaseCollector constructor.
     *
     * @param StatusGetter $getter
     */
    public function __construct(StatusGetter $getter)
    {
        $this->getter = $getter;
    }

    /**
     * Get status.
     *
     * @param null $key
     * @param null $default
     * @return array|false|mixed
     */
    protected function status($key = null, $default = null)
    {
        return $this->getter->getStatus($key, $default);
    }
}

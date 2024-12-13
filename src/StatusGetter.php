<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector;

class StatusGetter
{
    /**
     * @var array|false
     */
    protected $status;

    /**
     * StatusGetter constructor.
     */
    public function __construct()
    {
        $this->status = fpm_get_status();
    }

    /**
     * Get status by key
     *
     * @param $key
     * @return array|false|mixed
     */
    public function getStatus($key = null)
    {
        if ($key) {
            return data_get($this->status, $key);
        }

        return $this->status;
    }
}

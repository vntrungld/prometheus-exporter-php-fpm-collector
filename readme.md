# Prometheus Exporter PHP-FPM Collector

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vntrungld/prometheus-exporter-php-fpm-collector.svg?style=flat-square)](https://packagist.org/packages/vntrungld/prometheus-exporter-php-fpm-collector)
[![Total Downloads](https://img.shields.io/packagist/dt/vntrungld/prometheus-exporter-php-fpm-collector.svg?style=flat-square)](https://packagist.org/packages/vntrungld/prometheus-exporter-php-fpm-collector)
[![Tests](https://github.com/vntrungld/prometheus-exporter-php-fpm-collector/actions/workflows/tests.yml/badge.svg)](https://github.com/vntrungld/prometheus-exporter-php-fpm-collector/actions/workflows/tests.yml)
[![License](https://img.shields.io/packagist/l/vntrungld/prometheus-exporter-php-fpm-collector.svg?style=flat-square)](https://packagist.org/packages/vntrungld/prometheus-exporter-php-fpm-collector)

A PHP-FPM metrics collector for [Prometheus Exporter](https://github.com/vntrungld/prometheus-exporter) in Laravel applications. This package collects PHP-FPM pool status and process-level metrics and exposes them in Prometheus format.

## Requirements

| Laravel | PHP       | Package |
|---------|-----------|---------|
| 6.x     | 7.2 - 8.0 | 1.x     |
| 7.x     | 7.2 - 8.0 | 1.x     |
| 8.x     | 7.3 - 8.1 | 1.x     |
| 9.x     | 8.0 - 8.2 | 1.x     |
| 10.x    | 8.1 - 8.3 | 1.x     |
| 11.x    | 8.2 - 8.4 | 1.x     |
| 12.x    | 8.2 - 8.4 | 1.x     |

## Installation

Install via Composer:

```bash
composer require vntrungld/prometheus-exporter-php-fpm-collector
```

The package uses Laravel's auto-discovery, so the service provider will be automatically registered.

## Configuration

Add the collector set to your `prometheus-exporter` configuration file (`config/prometheus-exporter.php`):

```php
return [
    // ... other config options

    'collector_sets' => [
        \Vntrungld\PrometheusExporterPhpFpmCollector\PhpFpmCollectorSet::class,
        // ... other collector sets
    ],
];
```

## Available Metrics

### Pool-Level Metrics

| Metric Name                    | Type  | Description                              | Labels   |
|-------------------------------|-------|------------------------------------------|----------|
| `fpm_up`                       | Gauge | PHP-FPM pool availability (1=up, 0=down) | `pool`   |
| `fpm_accepted_connections`     | Gauge | Total number of accepted connections     | `pool`   |
| `fpm_active_processes`         | Gauge | Number of active processes               | `pool`   |
| `fpm_idle_processes`           | Gauge | Number of idle processes                 | `pool`   |
| `fpm_listen_queue`             | Gauge | Current listen queue size                | `pool`   |
| `fpm_listen_queue_length`      | Gauge | Maximum listen queue length              | `pool`   |
| `fpm_max_active_processes`     | Gauge | Maximum active processes reached         | `pool`   |
| `fpm_max_children_reached`     | Gauge | Times max children limit was reached     | `pool`   |
| `fpm_max_listen_queue`         | Gauge | Maximum listen queue reached             | `pool`   |
| `fpm_slow_requests`            | Gauge | Number of slow requests                  | `pool`   |
| `fpm_start_since`              | Gauge | Seconds since FPM started                | `pool`   |
| `fpm_total_processes`          | Gauge | Total number of processes in pool        | `pool`   |

### Process-Level Metrics

| Metric Name                       | Type  | Description                        | Labels              |
|----------------------------------|-------|------------------------------------|---------------------|
| `fpm_process_last_request_cpu`    | Gauge | CPU usage for last request         | `pool`, `child`     |
| `fpm_process_last_request_memory` | Gauge | Memory usage for last request      | `pool`, `child`     |
| `fpm_process_request_duration`    | Gauge | Request duration                   | `pool`, `child`     |
| `fpm_process_request_length`      | Gauge | Request content length             | `pool`, `child`     |
| `fpm_process_requests`            | Gauge | Total requests served by process   | `pool`, `child`     |
| `fpm_process_state`               | Gauge | Process state indicator            | `pool`, `child`, `state` |

### Process States

The `fpm_process_state` metric uses the following state labels:
- `Idle` - Process is idle
- `Getting request informations` - Process is getting request info
- `Reading headers` - Process is reading request headers
- `Running` - Process is executing
- `Ending` - Process is ending request
- `Finishing` - Process is finishing

## Example Output

```
# HELP fpm_up PHP-FPM pool availability
# TYPE fpm_up gauge
fpm_up{pool="www"} 1

# HELP fpm_active_processes The number of active processes
# TYPE fpm_active_processes gauge
fpm_active_processes{pool="www"} 3

# HELP fpm_idle_processes The number of idle processes
# TYPE fpm_idle_processes gauge
fpm_idle_processes{pool="www"} 2

# HELP fpm_process_state Process state indicator
# TYPE fpm_process_state gauge
fpm_process_state{pool="www",child="0",state="Idle"} 1
fpm_process_state{pool="www",child="0",state="Running"} 0
fpm_process_state{pool="www",child="1",state="Idle"} 0
fpm_process_state{pool="www",child="1",state="Running"} 1
```

## PHP-FPM Configuration

For this collector to work, PHP-FPM must be configured to expose status. Ensure your PHP-FPM pool configuration has:

```ini
pm.status_path = /status
```

The collector uses PHP's built-in `fpm_get_status()` function which is available when running under PHP-FPM.

## Testing

Run the test suite:

```bash
composer test
```

Or with PHPUnit directly:

```bash
vendor/bin/phpunit
```

## Changelog

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email vn.trungld@gmail.com instead of using the issue tracker.

## Credits

- [vntrungld](https://github.com/vntrungld)
- [All Contributors](../../contributors)

## License

MIT. Please see the [license file](license.md) for more information.

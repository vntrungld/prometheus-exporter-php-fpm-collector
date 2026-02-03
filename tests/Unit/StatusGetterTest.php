<?php

namespace Vntrungld\PrometheusExporterPhpFpmCollector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vntrungld\PrometheusExporterPhpFpmCollector\StatusGetter;

class StatusGetterTest extends TestCase
{
    public function testGetStatusReturnsFullStatusWhenNoKeyProvided(): void
    {
        $statusGetter = $this->createMockStatusGetter([
            'pool' => 'www',
            'active-processes' => 5,
        ]);

        $result = $statusGetter->getStatus();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('pool', $result);
        $this->assertEquals('www', $result['pool']);
    }

    public function testGetStatusReturnsSpecificValueWhenKeyProvided(): void
    {
        $statusGetter = $this->createMockStatusGetter([
            'pool' => 'www',
            'active-processes' => 5,
        ]);

        $result = $statusGetter->getStatus('pool');

        $this->assertEquals('www', $result);
    }

    public function testGetStatusReturnsNestedValue(): void
    {
        $statusGetter = $this->createMockStatusGetter([
            'pool' => 'www',
            'procs' => [
                0 => ['state' => 'Idle', 'pid' => 123],
                1 => ['state' => 'Running', 'pid' => 124],
            ],
        ]);

        $result = $statusGetter->getStatus('procs.0.state');

        $this->assertEquals('Idle', $result);
    }

    public function testGetStatusReturnsNullForNonExistentKey(): void
    {
        $statusGetter = $this->createMockStatusGetter([
            'pool' => 'www',
        ]);

        $result = $statusGetter->getStatus('non-existent');

        $this->assertNull($result);
    }

    protected function createMockStatusGetter(array $status): StatusGetter
    {
        $mock = $this->getMockBuilder(StatusGetter::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getStatus'])
            ->getMock();

        $mock->method('getStatus')
            ->willReturnCallback(function ($key = null) use ($status) {
                if ($key === null) {
                    return $status;
                }
                return data_get($status, $key);
            });

        return $mock;
    }
}

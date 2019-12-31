<?php

/**
 * @see       https://github.com/laminas/laminas-log for the canonical source repository
 * @copyright https://github.com/laminas/laminas-log/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-log/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Log\Processor;

use Laminas\Log\Processor\RequestId;
use PHPUnit\Framework\TestCase;

class RequestIdTest extends TestCase
{
    public function testProcess()
    {
        $processor = new RequestId();

        $event = [
            'timestamp'    => '',
            'priority'     => 1,
            'priorityName' => 'ALERT',
            'message'      => 'foo',
            'extra'        => [],
        ];

        $eventA = $processor->process($event);
        $this->assertArrayHasKey('requestId', $eventA['extra']);

        $eventB = $processor->process($event);
        $this->assertArrayHasKey('requestId', $eventB['extra']);

        $this->assertEquals($eventA['extra']['requestId'], $eventB['extra']['requestId']);
    }

    public function testProcessDoesNotOverwriteExistingRequestId()
    {
        $processor = new RequestId();

        $requestId = 'bar';

        $event = [
            'timestamp'    => '',
            'priority'     => 1,
            'priorityName' => 'ALERT',
            'message'      => 'foo',
            'extra'        => [
                'requestId' => $requestId,
            ],
        ];

        $processedEvent = $processor->process($event);

        $this->assertArrayHasKey('requestId', $processedEvent['extra']);
        $this->assertSame($requestId, $processedEvent['extra']['requestId']);
    }
}

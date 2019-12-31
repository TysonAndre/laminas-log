<?php

/**
 * @see       https://github.com/laminas/laminas-log for the canonical source repository
 * @copyright https://github.com/laminas/laminas-log/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-log/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Log\Writer;

use Laminas\Log\Writer\Null as NullWriter;
use PHPUnit\Framework\TestCase;

class NullTest extends TestCase
{
    protected function setUp()
    {
        if (PHP_VERSION_ID >= 70000) {
            $this->markTestSkipped('Cannot test Null log writer under PHP 7; reserved keyword');
        }
    }

    public function testRaisesNoticeOnInstantiation()
    {
        $this->expectException('PHPUnit_Framework_Error_Deprecated');
        new NullWriter();
    }
}

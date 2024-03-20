<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Reader\Filter\All;

final class NotSupportedFilterExceptionTest extends TestCase
{
    public function testBase(): void
    {
        $exception = new NotSupportedFilterException(All::class);

        $this->assertSame(sprintf("Filter \"%s\" is not supported.", All::class), $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}

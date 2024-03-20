<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Equals;

final class UnexpectedFilterExceptionTest extends TestCase
{
    public function testBase(): void
    {
        $exception = new UnexpectedFilterException(All::class, Equals::class);

        $this->assertSame(
            sprintf("Expected \"%s\", but \"%s\" given.", All::class, Equals::class),
            $exception->getMessage(),
        );
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\EqualsHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\GreaterThan;

final class EqualsHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new EqualsHandler();
        $filter = new GreaterThan('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Equals::class, GreaterThan::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

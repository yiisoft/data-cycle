<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\EqualsNullHandler;
use Yiisoft\Data\Reader\Filter\EqualsNull;
use Yiisoft\Data\Reader\Filter\GreaterThan;

final class EqualsNullHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new EqualsNullHandler();
        $filter = new GreaterThan('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', EqualsNull::class, GreaterThan::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\NotHandler;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\Filter\Not;

final class NotHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new NotHandler();
        $filter = new GreaterThan('number', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Not::class, GreaterThan::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\BetweenHandler;
use Yiisoft\Data\Reader\Filter\Between;
use Yiisoft\Data\Reader\Filter\GreaterThan;

final class BetweenHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new BetweenHandler();
        $filter = new GreaterThan('number', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Between::class, GreaterThan::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

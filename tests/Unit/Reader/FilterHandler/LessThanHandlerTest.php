<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LessThanHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\LessThan;

final class LessThanHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new LessThanHandler();
        $filter = new Equals('number', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', LessThan::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LessThanOrEqualHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;

final class LessThanOrEqualHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new LessThanOrEqualHandler();
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', LessThanOrEqual::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\GreaterThanOrEqualHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;

final class GreaterThanOrEqualHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new GreaterThanOrEqualHandler();
        $filter = new Equals('number', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(
            sprintf('Expected "%s", but "%s" given.', GreaterThanOrEqual::class, Equals::class),
        );
        $handler->getAsWhereArguments($filter, []);
    }
}

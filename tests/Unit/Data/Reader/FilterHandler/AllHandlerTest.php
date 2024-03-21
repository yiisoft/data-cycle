<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Data\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\AllHandler;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Equals;

final class AllHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new AllHandler();
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', All::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\AnyHandler;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Equals;

final class AnyHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new AnyHandler();
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Any::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

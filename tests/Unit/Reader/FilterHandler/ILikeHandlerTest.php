<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler\ILikeHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\ILike;

final class ILikeHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new ILikeHandler();
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', ILike::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

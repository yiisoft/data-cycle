<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Data\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\Like;

final class LikeHandlerTest extends TestCase
{
    public function testUnexpectedFilterException(): void
    {
        $handler = new LikeHandler();
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Like::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

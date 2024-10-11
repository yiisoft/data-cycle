<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\MysqlLikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\PostgresLikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\SqliteLikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\SqlServerLikeHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterHandlerInterface;

final class LikeHandlerTest extends TestCase
{
    public static function dataUnexpectedFilterException(): array
    {
        return [
            [new SqliteLikeHandler()],
            [new MysqlLikeHandler()],
            [new PostgresLikeHandler()],
            [new SqlServerLikeHandler()],
        ];
    }

    #[DataProvider('dataUnexpectedFilterException')]
    public function testUnexpectedFilterException(FilterHandlerInterface $handler): void
    {
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', Like::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

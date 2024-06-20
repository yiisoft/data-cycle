<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\FilterHandler;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler\MysqlILikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler\PostgresILikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler\SqliteILikeHandler;
use Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler\SqlServerILikeHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\ILike;
use Yiisoft\Data\Reader\FilterHandlerInterface;

final class ILikeHandlerTest extends TestCase
{
    public static function dataUnexpectedFilterException(): array
    {
        return [
            [new SqliteILikeHandler()],
            [new MysqlILikeHandler()],
            [new PostgresILikeHandler()],
            [new SqlServerILikeHandler()],
        ];
    }

    #[DataProvider('dataUnexpectedFilterException')]
    public function testUnexpectedFilterException(FilterHandlerInterface $handler): void
    {
        $filter = new Equals('id', 2);

        $this->expectException(UnexpectedFilterException::class);
        $this->expectExceptionMessage(sprintf('Expected "%s", but "%s" given.', ILike::class, Equals::class));
        $handler->getAsWhereArguments($filter, []);
    }
}

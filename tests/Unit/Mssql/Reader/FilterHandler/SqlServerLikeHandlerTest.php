<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Mssql\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\SqlServerLikeHandler;
use Yiisoft\Data\Reader\Filter\Like;

final class SqlServerLikeHandlerTest extends TestCase
{
    public static $DRIVER = 'mssql';

    public function testNotSupportedFilterOptionException(): void
    {
        $handler = new SqlServerLikeHandler();
        $filter = new Like('email', 'seed@', caseSensitive: true);

        $this->expectException(NotSupportedFilterOptionException::class);
        $this->expectExceptionMessage('$caseSensitive option is not supported when using SQLServer driver.');
        $handler->getAsWhereArguments($filter, []);
    }
}

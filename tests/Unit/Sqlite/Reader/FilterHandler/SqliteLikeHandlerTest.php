<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Sqlite\Reader\FilterHandler;

use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler\SqliteLikeHandler;
use Yiisoft\Data\Reader\Filter\Like;

final class SqliteLikeHandlerTest extends TestCase
{
    public static string $DRIVER = 'sqlite';

    public function testNotSupportedFilterOptionException(): void
    {
        $handler = new SqliteLikeHandler();
        $filter = new Like('email', 'seed@', caseSensitive: true);

        $this->expectException(NotSupportedFilterOptionException::class);
        $this->expectExceptionMessage('$caseSensitive option is not supported when using SQLite driver.');
        $handler->getAsWhereArguments($filter, []);
    }
}

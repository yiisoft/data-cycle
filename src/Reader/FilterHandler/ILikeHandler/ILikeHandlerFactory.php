<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler;

use Cycle\Database\Driver\DriverInterface;
use RuntimeException;
use Yiisoft\Data\Reader\FilterHandlerInterface;

class ILikeHandlerFactory
{
    public static function getIlikeHandler(?DriverInterface $databaseDriver): FilterHandlerInterface
    {
        $driverType = $databaseDriver?->getType() ?? 'SQLite';

        // default - ignored due to the complexity of testing and preventing splitting of databaseDriver argument.
        // @codeCoverageIgnoreStart
        return match ($driverType) {
            'SQLite' => new SqliteILikeHandler(),
            'MySQL' => new MysqlILikeHandler(),
            'Postgres' => new PostgresILikeHandler(),
            'SQLServer' => new SqlServerILikeHandler(),
            default => throw new RuntimeException("$driverType database driver is not supported."),
        };
        // @codeCoverageIgnoreEnd
    }
}

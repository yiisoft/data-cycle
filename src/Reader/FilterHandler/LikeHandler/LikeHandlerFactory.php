<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Cycle\Database\Driver\DriverInterface;
use RuntimeException;
use Yiisoft\Data\Reader\FilterHandlerInterface;

class LikeHandlerFactory
{
    public static function getLikeHandler(?DriverInterface $databaseDriver): FilterHandlerInterface
    {
        $driverType = $databaseDriver?->getType() ?? 'SQLite';

        // default - ignored due to the complexity of testing and preventing splitting of databaseDriver argument.
        // @codeCoverageIgnoreStart
        return match ($driverType) {
            'SQLite' => new SqliteLikeHandler(),
            'MySQL' => new MysqlLikeHandler(),
            'Postgres' => new PostgresLikeHandler(),
            'SQLServer' => new SqlServerLikeHandler(),
            default => throw new RuntimeException("$driverType database driver is not supported."),
        };
        // @codeCoverageIgnoreEnd
    }
}

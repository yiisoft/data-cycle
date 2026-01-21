<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use RuntimeException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;

/**
 * @internal
 */
final class LikeHandlerFactory
{
    public static function getLikeHandler(string $driverType): QueryBuilderFilterHandler
    {
        // default - ignored due to the complexity of testing and preventing splitting of databaseDriver argument.
        // @codeCoverageIgnoreStart
        return match ($driverType) {
            'SQLite'    => new SqliteLikeHandler(),
            'MySQL'     => new MysqlLikeHandler(),
            'Postgres'  => new PostgresLikeHandler(),
            'SQLServer' => new SqlServerLikeHandler(),
            default     => throw new RuntimeException("$driverType database driver is not supported."),
        };
        // @codeCoverageIgnoreEnd
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\EntityReaderTest as BaseEntityReaderTest;

final class EntityReaderTest extends BaseEntityReaderTest
{
    public const DRIVER = 'mssql';

    public static function dataGetSql(): array
    {
        return [
            'base' => [
                <<<SQL
                SELECT * FROM (
                    SELECT
                        [user].[id] AS [c0],
                        [user].[email] AS [c1],
                        [user].[balance] AS [c2],
                        [user].[born_at] AS [c3],
                        ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS [_ROW_NUMBER_]
                    FROM [user] AS [user]
                ) AS [ORD_FALLBACK]
                WHERE [_ROW_NUMBER_] BETWEEN 2 AND 3
SQL,
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\BaseEntityReaderTestCase;

final class EntityReaderTest extends BaseEntityReaderTestCase
{
    public static $DRIVER = 'mssql';

    public static function dataGetSql(): array
    {
        return [
            'base' => [
                <<<SQL
                SELECT * FROM (
                    SELECT
                        [user].[id] AS [c0],
                        [user].[number] AS [c1],
                        [user].[email] AS [c2],
                        [user].[balance] AS [c3],
                        [user].[born_at] AS [c4],
                        ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) AS [_ROW_NUMBER_]
                    FROM [user] AS [user]
                ) AS [ORD_FALLBACK]
                WHERE [_ROW_NUMBER_] BETWEEN 2 AND 3
SQL,
            ],
        ];
    }
}

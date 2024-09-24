<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\EntityReaderTestCase as BaseEntityReaderTest;

final class EntityReaderTest extends BaseEntityReaderTest
{
    public static $DRIVER = 'mysql';

    public static function dataGetSql(): array
    {
        return [
            'base' => [
                <<<SQL
                SELECT
                    `user`.`id` AS `c0`,
                    `user`.`number` AS `c1`,
                    `user`.`email` AS `c2`,
                    `user`.`balance` AS `c3`,
                    `user`.`born_at` AS `c4`
                FROM `user` AS `user` LIMIT 2 OFFSET 1
SQL,
            ],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\ILikeHandlerTest as BaseILikeHandlerTest;

final class ILikeHandlerTest extends BaseILikeHandlerTest
{
    public const DRIVER = 'mysql';

    public static function dataBase(): array
    {
        $data = parent::dataBase();
        // A case-insensitive collation is used by default
        $data['case does not match'] = ['email', 'SEED@%', [2]];

        return $data;
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LikeHandlerTest as BaseLikeHandlerTest;

final class LikeHandlerTest extends BaseLikeHandlerTest
{
    public const DRIVER = 'pgsql';

    public static function dataBase(): array
    {
        return [
            'case matches' => ['email', 'seed@%', [2]],
            'case does not match' => ['email', 'SEED@%', []],
        ];
    }
}

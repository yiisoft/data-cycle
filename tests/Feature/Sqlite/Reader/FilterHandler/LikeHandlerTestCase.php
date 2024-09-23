<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LikeHandlerTest as BaseLikeHandlerTest;

final class LikeHandlerTestCase extends BaseLikeHandlerTest
{
    public static $DRIVER = 'sqlite';
}

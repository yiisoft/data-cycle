<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\BetweenHandlerTest as BaseBetweenHandlerTest;

final class BetweenHandlerTestCase extends BaseBetweenHandlerTest
{
    public static $DRIVER = 'sqlite';
}

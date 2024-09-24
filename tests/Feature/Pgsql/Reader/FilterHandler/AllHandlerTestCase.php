<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\AllHandlerTest as BaseAllHandlerTest;

final class AllHandlerTestCase extends BaseAllHandlerTest
{
    public static $DRIVER = 'pgsql';
}

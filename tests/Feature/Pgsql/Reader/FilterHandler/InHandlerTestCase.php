<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\InHandlerTest as BaseInHandlerTest;

final class InHandlerTestCase extends BaseInHandlerTest
{
    public static $DRIVER = 'pgsql';
}

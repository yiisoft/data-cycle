<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\AnyHandlerTest as BaseAnyHandlerTest;

final class AnyHandlerTestCase extends BaseAnyHandlerTest
{
    public static $DRIVER = 'mssql';
}

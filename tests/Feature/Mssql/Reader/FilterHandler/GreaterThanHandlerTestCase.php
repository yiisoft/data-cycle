<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\GreaterThanHandlerTest as
BaseGreaterThanHandlerTest;

final class GreaterThanHandlerTestCase extends BaseGreaterThanHandlerTest
{
    public static $DRIVER = 'mssql';
}

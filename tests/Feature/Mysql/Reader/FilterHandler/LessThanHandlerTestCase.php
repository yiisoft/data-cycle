<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LessThanHandlerTest as BaseLessThanHandlerTest;

final class LessThanHandlerTestCase extends BaseLessThanHandlerTest
{
    public static $DRIVER = 'mysql';
}

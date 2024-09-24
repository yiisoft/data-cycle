<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\EqualsNullHandlerTest as BaseEqualsNullHandlerTest;

final class EqualsNullHandlerTestCase extends BaseEqualsNullHandlerTest
{
    public static $DRIVER = 'pgsql';
}

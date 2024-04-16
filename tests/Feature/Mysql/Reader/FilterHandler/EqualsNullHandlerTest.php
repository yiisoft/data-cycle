<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\EqualsNullHandlerTest as BaseEqualsNullHandlerTest;

final class EqualsNullHandlerTest extends BaseEqualsNullHandlerTest
{
    public const DRIVER = 'mysql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\EqualsHandlerTest as BaseEqualsHandlerTest;

final class EqualsHandlerTest extends BaseEqualsHandlerTest
{
    public const DRIVER = 'pgsql';
}

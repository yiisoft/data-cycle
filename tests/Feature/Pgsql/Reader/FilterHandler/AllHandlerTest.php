<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\AllHandlerTest as BaseAllHandlerTest;

final class AllHandlerTest extends BaseAllHandlerTest
{
    public const DRIVER = 'pgsql';
}

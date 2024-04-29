<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\AnyHandlerTest as BaseAnyHandlerTest;

final class AnyHandlerTest extends BaseAnyHandlerTest
{
    public const DRIVER = 'pgsql';
}

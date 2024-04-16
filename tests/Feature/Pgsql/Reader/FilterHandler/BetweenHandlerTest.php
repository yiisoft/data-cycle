<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\BetweenHandlerTest as BaseBetweenHandlerTest;

final class BetweenHandlerTest extends BaseBetweenHandlerTest
{
    public const DRIVER = 'pgsql';
}

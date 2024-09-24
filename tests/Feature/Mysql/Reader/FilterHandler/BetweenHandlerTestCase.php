<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\BetweenHandlerTest as BaseBetweenHandlerTest;

final class BetweenHandlerTestCase extends BaseBetweenHandlerTest
{
    public const DRIVER = 'mysql';
}

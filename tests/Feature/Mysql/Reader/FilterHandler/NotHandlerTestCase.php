<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\NotHandlerTest as BaseNotHandlerTest;

final class NotHandlerTestCase extends BaseNotHandlerTest
{
    public const DRIVER = 'mysql';
}

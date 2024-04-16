<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\NotHandlerTest as BaseNotHandlerTest;

final class NotHandlerTest extends BaseNotHandlerTest
{
    public const DRIVER = 'sqlite';
}

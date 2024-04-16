<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\GreaterThanOrEqualHandlerTest as
    BaseGreaterThanOrEqualHandlerTest;

final class GreaterThanOrEqualHandlerTest extends BaseGreaterThanOrEqualHandlerTest
{
    public const DRIVER = 'sqlite';
}

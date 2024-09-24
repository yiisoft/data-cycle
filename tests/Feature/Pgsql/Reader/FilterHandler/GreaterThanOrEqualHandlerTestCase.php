<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\GreaterThanOrEqualHandlerTest as
BaseGreaterThanOrEqualHandlerTest;

final class GreaterThanOrEqualHandlerTestCase extends BaseGreaterThanOrEqualHandlerTest
{
    public const DRIVER = 'pgsql';
}

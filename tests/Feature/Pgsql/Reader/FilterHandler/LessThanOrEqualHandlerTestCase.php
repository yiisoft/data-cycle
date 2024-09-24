<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LessThanOrEqualHandlerTest as
BaseLessThanOrEqualHandlerTestAlias;

final class LessThanOrEqualHandlerTestCase extends BaseLessThanOrEqualHandlerTestAlias
{
    public const DRIVER = 'pgsql';
}

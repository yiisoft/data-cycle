<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LessThanOrEqualHandlerTest as
BaseLessThanOrEqualHandlerTestAlias;

final class LessThanOrEqualHandlerTestCase extends BaseLessThanOrEqualHandlerTestAlias
{
    public static $DRIVER = 'mssql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LessThanOrEqualHandlerTest as
BaseLessThanOrEqualHandlerTestAlias;

final class LessThanOrEqualHandlerTest extends BaseLessThanOrEqualHandlerTestAlias
{
    public const DRIVER = 'mysql';
}
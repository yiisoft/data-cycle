<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LikeHandlerTest as BaseLikeHandlerTest;

final class LikeHandlerTest extends BaseLikeHandlerTest
{
    public const DRIVER = 'mssql';
}

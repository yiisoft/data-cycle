<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\LikeHandlerTest as BaseLikeHandlerTest;

final class LikeHandlerTest extends BaseLikeHandlerTest
{
    public const DRIVER = 'mysql';
}

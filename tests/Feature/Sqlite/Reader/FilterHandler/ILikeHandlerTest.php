<?php

declare(strict_types=1);

namespace Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\ILikeHandlerTest as BaseILikeHandlerTest;

final class ILikeHandlerTest extends BaseILikeHandlerTest
{
    public const DRIVER = 'sqlite';
}

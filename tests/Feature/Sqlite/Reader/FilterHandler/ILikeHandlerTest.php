<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler\ILikeHandlerTest as BaseILikeHandlerTest;

final class ILikeHandlerTest extends BaseILikeHandlerTest
{
    public const DRIVER = 'sqlite';
}

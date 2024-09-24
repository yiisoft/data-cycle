<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\LikeHandlerTestCase as BaseLikeHandlerTest;

final class LikeHandlerTestCase extends BaseLikeHandlerTest
{
    public static $DRIVER = 'mysql';
}

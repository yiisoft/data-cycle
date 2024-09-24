<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\LessThanHandlerTestCase as BaseLessThanHandlerTest;

final class LessThanHandlerTestCase extends BaseLessThanHandlerTest
{
    public static $DRIVER = 'mysql';
}

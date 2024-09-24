<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\AnyHandlerTestCase as BaseAnyHandlerTest;

final class AnyHandlerTestCase extends BaseAnyHandlerTest
{
    public static $DRIVER = 'mysql';
}

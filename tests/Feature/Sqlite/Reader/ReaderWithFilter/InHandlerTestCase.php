<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\InHandlerTestCase as BaseInHandlerTest;

final class InHandlerTestCase extends BaseInHandlerTest
{
    public static $DRIVER = 'sqlite';
}

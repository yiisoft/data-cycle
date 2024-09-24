<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\NotHandlerTestCase as BaseNotHandlerTest;

final class NotHandlerTestCase extends BaseNotHandlerTest
{
    public static $DRIVER = 'sqlite';
}

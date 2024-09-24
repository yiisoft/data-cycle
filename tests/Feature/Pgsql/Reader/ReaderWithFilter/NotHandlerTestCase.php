<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\NotHandlerTestCase as BaseNotHandlerTest;

final class NotHandlerTestCase extends BaseNotHandlerTest
{
    public static $DRIVER = 'pgsql';
}

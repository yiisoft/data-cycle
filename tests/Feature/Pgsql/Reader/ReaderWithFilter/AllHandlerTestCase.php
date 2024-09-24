<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\AllHandlerTestCase as BaseAllHandlerTest;

final class AllHandlerTestCase extends BaseAllHandlerTest
{
    public static $DRIVER = 'pgsql';
}

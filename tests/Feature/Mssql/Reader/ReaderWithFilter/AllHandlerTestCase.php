<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\AllHandlerTestCase as BaseAllHandlerTest;

final class AllHandlerTestCase extends BaseAllHandlerTest
{
    public static $DRIVER = 'mssql';
}

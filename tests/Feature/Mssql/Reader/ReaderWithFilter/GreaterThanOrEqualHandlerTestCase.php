<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\GreaterThanOrEqualHandlerTestCase as
BaseGreaterThanOrEqualHandlerTest;

final class GreaterThanOrEqualHandlerTestCase extends BaseGreaterThanOrEqualHandlerTest
{
    public static $DRIVER = 'mssql';
}

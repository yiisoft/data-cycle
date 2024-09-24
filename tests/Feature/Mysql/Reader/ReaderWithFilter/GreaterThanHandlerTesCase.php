<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\GreaterThanHandlerTestCase as
BaseGreaterThanHandlerTest;

final class GreaterThanHandlerTesCase extends BaseGreaterThanHandlerTest
{
    public static $DRIVER = 'mysql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\GreaterThanOrEqualHandlerTestCase as
BaseGreaterThanOrEqualHandlerTest;

final class GreaterThanOrEqualHandlerTestCase extends BaseGreaterThanOrEqualHandlerTest
{
    public static $DRIVER = 'mysql';
}

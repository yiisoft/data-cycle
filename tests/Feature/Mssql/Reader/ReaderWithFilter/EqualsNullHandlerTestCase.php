<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\EqualsNullHandlerTestCase as BaseEqualsNullHandlerTest;

final class EqualsNullHandlerTestCase extends BaseEqualsNullHandlerTest
{
    public static $DRIVER = 'mssql';
}

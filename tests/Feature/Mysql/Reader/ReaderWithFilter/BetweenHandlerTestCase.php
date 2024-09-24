<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BetweenHandlerTestCase as BaseBetweenHandlerTest;

final class BetweenHandlerTestCase extends BaseBetweenHandlerTest
{
    public static $DRIVER = 'mysql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BetweenHandlerTestCase as BaseBetweenHandlerTest;

final class BetweenHandlerTestCase extends BaseBetweenHandlerTest
{
    public static $DRIVER = 'sqlite';
}

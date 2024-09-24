<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\LessThanOrEqualHandlerTestCase as
BaseLessThanOrEqualHandlerTestAlias;

final class LessThanOrEqualHandlerTestCase extends BaseLessThanOrEqualHandlerTestAlias
{
    public static $DRIVER = 'mysql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithNotTestCase;

final class ReaderWithNotTestCase extends BaseReaderWithNotTestCase
{
    public static $DRIVER = 'pgsql';
}

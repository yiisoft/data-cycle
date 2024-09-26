<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithEqualsNullTestCase;

final class ReaderWithEqualsNullTest extends BaseReaderWithEqualsNullTestCase
{
    public static $DRIVER = 'sqlite';
}

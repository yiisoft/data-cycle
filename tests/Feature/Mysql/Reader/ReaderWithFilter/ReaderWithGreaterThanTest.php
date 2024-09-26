<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithGreaterThanTestCase;

final class ReaderWithGreaterThanTest extends BaseReaderWithGreaterThanTestCase
{
    public static $DRIVER = 'mysql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithGreaterThanOrEqualTestCase;

final class ReaderWithGreaterThanOrEqualTest extends BaseReaderWithGreaterThanOrEqualTestCase
{
    public static $DRIVER = 'pgsql';
}

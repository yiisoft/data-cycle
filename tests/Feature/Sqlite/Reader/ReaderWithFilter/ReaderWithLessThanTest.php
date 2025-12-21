<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLessThanTestCase;

final class ReaderWithLessThanTest extends BaseReaderWithLessThanTestCase
{
    public static ?string $DRIVER = 'sqlite';
}

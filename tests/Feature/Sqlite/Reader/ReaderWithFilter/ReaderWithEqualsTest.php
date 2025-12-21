<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithEqualsTestCase;

final class ReaderWithEqualsTest extends BaseReaderWithEqualsTestCase
{
    public static ?string $DRIVER = 'sqlite';
}

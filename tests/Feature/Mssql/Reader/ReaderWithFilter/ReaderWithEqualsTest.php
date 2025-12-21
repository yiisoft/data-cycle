<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithEqualsTestCase;

final class ReaderWithEqualsTest extends BaseReaderWithEqualsTestCase
{
    public static ?string $DRIVER = 'mssql';
}

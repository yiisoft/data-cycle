<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithNotTestCase;

final class ReaderWithNotTest extends BaseReaderWithNotTestCase
{
    public static ?string $DRIVER = 'mssql';
}

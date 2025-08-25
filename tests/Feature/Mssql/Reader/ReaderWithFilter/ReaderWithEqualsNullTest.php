<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithEqualsNullTestCase;

final class ReaderWithEqualsNullTest extends BaseReaderWithEqualsNullTestCase
{
    public static string $DRIVER = 'mssql';
}

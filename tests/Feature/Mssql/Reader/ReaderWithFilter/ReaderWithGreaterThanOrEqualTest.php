<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithGreaterThanOrEqualTestCase;

final class ReaderWithGreaterThanOrEqualTest extends BaseReaderWithGreaterThanOrEqualTestCase
{
    public static string $DRIVER = 'mssql';
}

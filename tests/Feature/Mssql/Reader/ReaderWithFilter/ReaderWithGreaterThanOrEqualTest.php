<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithGreaterThanOrEqualTestCase as BaseGreaterThanOrEqualHandlerTest;

final class ReaderWithGreaterThanOrEqualTest extends BaseGreaterThanOrEqualHandlerTest
{
    public static ?string $DRIVER = 'mssql';
}

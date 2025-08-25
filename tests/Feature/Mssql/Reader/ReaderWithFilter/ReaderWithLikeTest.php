<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static string $DRIVER = 'mssql';
}

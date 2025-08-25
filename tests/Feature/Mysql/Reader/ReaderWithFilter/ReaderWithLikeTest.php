<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithLikeTestCase;

final class ReaderWithLikeTest extends BaseReaderWithLikeTestCase
{
    public static string $DRIVER = 'mysql';
}

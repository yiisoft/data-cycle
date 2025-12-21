<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithNotTestCase;

final class ReaderWithNotTest extends BaseReaderWithNotTestCase
{
    public static ?string $DRIVER = 'mysql';
}

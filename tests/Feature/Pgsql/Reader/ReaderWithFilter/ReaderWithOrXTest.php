<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithOrXTestCase;

final class ReaderWithOrXTest extends BaseReaderWithOrXTestCase
{
    public static $DRIVER = 'pgsql';
}

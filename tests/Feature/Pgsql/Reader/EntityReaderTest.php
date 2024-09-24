<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\EntityReaderTestCase as BaseEntityReaderTest;

final class EntityReaderTest extends BaseEntityReaderTest
{
    public static $DRIVER = 'pgsql';
}

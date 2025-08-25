<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\BaseEntityReaderTestCase;

final class EntityReaderTest extends BaseEntityReaderTestCase
{
    public static string $DRIVER = 'pgsql';
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mysql\Reader;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\EntityReaderTest as BaseEntityReaderTest;

final class EntityReaderTest extends BaseEntityReaderTest
{
    public const DRIVER = 'mysql';
}
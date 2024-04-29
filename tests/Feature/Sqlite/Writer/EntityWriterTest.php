<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Sqlite\Writer;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Writer\EntityWriterTest as BaseEntityWriterTest;

final class EntityWriterTest extends BaseEntityWriterTest
{
    public const DRIVER = 'sqlite';
}

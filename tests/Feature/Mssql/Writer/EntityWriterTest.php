<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Writer;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Writer\EntityWriterTest as BaseEntityWriterTest;

final class EntityWriterTest extends BaseEntityWriterTest
{
    public const DRIVER = 'mssql';
}

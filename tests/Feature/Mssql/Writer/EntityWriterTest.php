<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Mssql\Writer;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Writer\BaseEntityWriterTestCase;

final class EntityWriterTest extends BaseEntityWriterTestCase
{
    public static string $DRIVER = 'mssql';
}

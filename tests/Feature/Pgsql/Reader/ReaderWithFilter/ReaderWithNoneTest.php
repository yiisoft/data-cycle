<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Pgsql\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter\BaseReaderWithNoneTestCase;

final class ReaderWithNoneTest extends BaseReaderWithNoneTestCase
{
    public static ?string $DRIVER = 'pgsql';
}

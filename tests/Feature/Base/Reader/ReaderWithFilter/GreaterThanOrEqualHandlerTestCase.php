<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\BaseReaderTestCase;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;

abstract class GreaterThanOrEqualHandlerTestCase extends BaseReaderTestCase
{
    use DataTrait;
}

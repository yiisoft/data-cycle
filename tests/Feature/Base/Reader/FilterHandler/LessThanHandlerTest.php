<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Tests\Common\Reader\FilterHandler\LessThanHandlerWithReaderTestTrait;

abstract class LessThanHandlerTest extends BaseData
{
    use LessThanHandlerWithReaderTestTrait;
}

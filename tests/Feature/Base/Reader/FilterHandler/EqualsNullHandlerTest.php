<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Tests\Common\Reader\FilterHandler\EqualsNullHandlerWithReaderTestTrait;

abstract class EqualsNullHandlerTest extends BaseData
{
    use EqualsNullHandlerWithReaderTestTrait;
}

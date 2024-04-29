<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;

abstract class LessThanOrEqualHandlerTest extends BaseData
{
    public function testLessThanOrEqualHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new LessThanOrEqual('balance', 1.0));
        $this->assertFixtures([1], $reader->read());
    }
}

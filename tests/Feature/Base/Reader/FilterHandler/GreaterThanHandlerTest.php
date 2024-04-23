<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\GreaterThan;

abstract class GreaterThanHandlerTest extends BaseData
{
    public function testGreaterThanHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new GreaterThan('balance', 499));
        $this->assertFixtures([3], $reader->read());
    }
}

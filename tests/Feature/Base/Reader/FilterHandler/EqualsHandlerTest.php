<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\Equals;

abstract class EqualsHandlerTest extends BaseData
{
    public function testEqualsHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('number', 2));
        $this->assertFixtures([1], $reader->read());
    }
}

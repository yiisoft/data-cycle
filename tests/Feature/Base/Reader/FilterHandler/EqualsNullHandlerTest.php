<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\EqualsNull;

abstract class EqualsNullHandlerTest extends BaseData
{
    public function testEqualsHandler(): void
    {
        $this->fillFixtures();
        $reader = (new EntityReader($this->select('user')))->withFilter(new EqualsNull('born_at'));
        $this->assertFixtures(range(0, 3), $reader->read());
    }
}

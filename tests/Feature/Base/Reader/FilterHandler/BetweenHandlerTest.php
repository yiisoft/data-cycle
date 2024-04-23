<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\Between;

abstract class BetweenHandlerTest extends BaseData
{
    public function testBetweenHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new Between('balance', 10.25, 100.0));
        $this->assertFixtures([0, 2, 4], $reader->read());
    }
}

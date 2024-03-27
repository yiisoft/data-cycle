<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\GreaterThan;

final class GreaterThanHandlerTest extends BaseData
{
    public function testGreaterThanHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new GreaterThan('balance', 499));

        $this->assertEquals([(object)self::FIXTURES_USER[3]], $reader->read());
    }
}

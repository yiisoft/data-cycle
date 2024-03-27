<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\LessThan;

final class LessThanHandlerTest extends BaseData
{
    public function testLessThanHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new LessThan('balance', 1.1));

        $this->assertEquals([(object)self::FIXTURES_USER[1]], $reader->read());
    }
}

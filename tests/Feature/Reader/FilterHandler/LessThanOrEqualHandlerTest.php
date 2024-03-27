<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;

final class LessThanOrEqualHandlerTest extends BaseData
{
    public function testLessThanOrEqualHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new LessThanOrEqual('balance', 1.0));

        $this->assertEquals([(object)self::FIXTURES_USER[1]], $reader->read());
    }
}

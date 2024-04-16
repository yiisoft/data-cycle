<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;

abstract class GreaterThanOrEqualHandlerTest extends BaseData
{
    public function testGreaterThanOrEqualHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))
            ->withFilter(new GreaterThanOrEqual('balance', 500));

        $this->assertEquals([(object)self::FIXTURES_USER[3]], $reader->read());
    }
}

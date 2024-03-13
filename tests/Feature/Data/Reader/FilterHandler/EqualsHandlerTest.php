<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Data\Reader\FilterHandler;

use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\Data\BaseData;

final class EqualsHandlerTest extends BaseData
{
    public function testEqualsHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('id', 2));

        $this->assertEquals([(object)self::FIXTURES_USER[1]], $reader->read());
    }
}

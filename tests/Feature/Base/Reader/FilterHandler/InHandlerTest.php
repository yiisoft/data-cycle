<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\In;

abstract class InHandlerTest extends BaseData
{
    public function testInHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new In('id', [2, 3]));

        $this->assertEquals([(object)self::FIXTURES_USER[1], (object)self::FIXTURES_USER[2]], $reader->read());
    }
}

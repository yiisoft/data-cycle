<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\EqualsNull;

final class EqualsNullHandlerTest extends BaseData
{
    public function testEqualsHandler(): void
    {
        $this->fillFixtures();
        $reader = (new EntityReader($this->select('user')))->withFilter(new EqualsNull('born_at'));

        $this->assertEquals(
            [
                (object) self::FIXTURES_USER[0],
                (object) self::FIXTURES_USER[1],
                (object) self::FIXTURES_USER[2],
                (object) self::FIXTURES_USER[3],
            ],
            $reader->read(),
        );
    }
}

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
        $this->fillFixtures();
        $reader = (new EntityReader($this->select('user')))->withFilter(new Between('balance', '10.25', '100.0'));

        $this->assertEquals(
            [(object) self::FIXTURES_USER[0], (object) self::FIXTURES_USER[2], (object) self::FIXTURES_USER[4]],
            $reader->read(),
        );
    }
}

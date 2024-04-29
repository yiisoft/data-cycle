<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\Like;

abstract class ILikeHandlerTest extends BaseData
{
    public function testLikeHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new Like('email', 'SEED@%'));

        $this->assertEquals([(object)self::FIXTURES_USER[2]], $reader->read());
    }
}

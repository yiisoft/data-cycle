<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\Like;

final class LikeHandlerTest extends BaseData
{
    public function testLikeHandler(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new Like('email', 'seed@%'));

        $this->assertEquals([(object)self::FIXTURES_USER[2]], $reader->read());
    }
}

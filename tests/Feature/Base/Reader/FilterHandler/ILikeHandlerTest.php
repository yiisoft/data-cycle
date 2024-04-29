<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\ILike;

abstract class ILikeHandlerTest extends BaseData
{
    public function testILikeHandler(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new ILike('email', 'SEED@%'));
        $this->assertFixtures([2], $reader->read());
    }
}

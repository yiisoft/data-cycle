<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Reader\Filter\All;

abstract class BaseReaderWithAllTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithAllTestCase
{
    use DataTrait;

    public function testWithReader(): void
    {
        $reader = (
        new EntityReader(
            $this
                ->select('user')
                ->buildQuery()
                ->columns('id', 'number'),
        )
        )->withFilter(new All());

        $result = $reader->read();

        $expectedResult = [
            ['id' => 1, 'number' => 1],
            ['id' => 2, 'number' => 2],
            ['id' => 3, 'number' => 3],
            ['id' => 4, 'number' => 4],
            ['id' => 5, 'number' => 5],
        ];
        $this->assertSame($expectedResult, $result);
    }
}

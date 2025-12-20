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

        $actualResults = $reader->read();

        $expectedResult = [
            ['id' => 1, 'number' => 1],
            ['id' => 2, 'number' => 2],
            ['id' => 3, 'number' => 3],
            ['id' => 4, 'number' => 4],
            ['id' => 5, 'number' => 5],
        ];

        $this->assertCount(5, $actualResults);
        $actualResultsById = [];
        foreach ($actualResults as $result) {
            $actualResultsById[$result['id']] = $result;
        }
        foreach ($expectedResult as $expectedItem) {
            $id = $expectedItem['id'];

            $this->assertArrayHasKey($id, $actualResultsById, "Результат с ID {$id} не найден.");
            $actualItem = $actualResultsById[$id];

            $this->assertEquals($expectedItem['id'], $actualItem['id']);

            $this->assertEqualsWithDelta(
                $expectedItem['number'],
                $actualItem['number'],
                0.01,
                "The balance for user ID {$id} is not as expected."
            );
        }
    }
}

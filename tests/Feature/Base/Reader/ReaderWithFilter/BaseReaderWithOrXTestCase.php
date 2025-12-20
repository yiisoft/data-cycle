<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\OrX;

abstract class BaseReaderWithOrXTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithOrXTestCase
{
    use DataTrait;

    public function testNotsupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new OrX(new Equals('number', 2), new NotSupportedFilter(), new Equals('number', 3)));
    }

    public function testFilterSupportSelectQuery(): void
    {
        $reader = (new EntityReader(
            $this
                ->select('user')
                ->buildQuery()
                ->columns('id', 'balance'),
        ));

        $reader = $reader->withFilter(new OrX(new Equals('balance', 100.0), new Equals('id', 2)));
        $actualResults = $reader->read();

        $expectedResult = [
            ['id' => 2, 'balance' => 1.0],
            ['id' => 3, 'balance' => 100.0],
        ];

        $this->assertCount(2, $actualResults);
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
                $expectedItem['balance'],
                $actualItem['balance'],
                0.01,
                "The balance for user ID {$id} is not as expected."
            );
        }
    }
}

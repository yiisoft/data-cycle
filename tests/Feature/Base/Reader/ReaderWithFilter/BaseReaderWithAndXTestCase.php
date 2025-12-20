<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\ReaderWithFilter;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\AndX;
use Yiisoft\Data\Reader\Filter\Equals;

abstract class BaseReaderWithAndXTestCase extends \Yiisoft\Data\Tests\Common\Reader\ReaderWithFilter\BaseReaderWithAndXTestCase
{
    use DataTrait;

    public function testNotSupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(
            new AndX(new Equals('balance', '100.0'), new NotSupportedFilter(), new Equals('email', 'seed@beat')),
        );
    }

    public function testFilterSupportSelectQuery(): void
    {
        $reader = (new EntityReader(
            $this
                ->select('user')
                ->buildQuery()
                ->columns('id', 'balance'),
        ));

        $reader = $reader->withFilter(new AndX(new Equals('balance', 100.0), new Equals('id', 3)));
        $result = $reader->read();

        $expectedResult = [
            ['id' => 3, 'balance' => 100.0],
        ];

        $this->assertCount(1, $result);
        $this->assertEquals($expectedResult[0]['id'], $result[0]['id']);
        $this->assertEqualsWithDelta(
            $expectedResult[0]['balance'],
            $result[0]['balance'],
            0.01,
        );
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader;

use Cycle\Database\Query\SelectQuery;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Reader\Sort;
use ReflectionMethod;

use const SORT_ASC;
use const SORT_DESC;

final class EntityReaderTest extends TestCase
{
    public function testNormalizeSortingCriteria(): void
    {
        $reader = new EntityReader($this->createMock(SelectQuery::class));

        $ref = new ReflectionMethod($reader, 'normalizeSortingCriteria');

        $this->assertSame(
            ['number' => 'ASC', 'name' => 'DESC', 'email' => 'ASC'],
            $ref->invoke($reader, ['number' => 'ASC', 'name' => SORT_DESC, 'email' => SORT_ASC]),
        );
    }

    public function testOffset(): void
    {
        $select = $this->createMock(SelectQuery::class);
        $select->expects($this->once())->method('offset')->with(10)->willReturnSelf();

        $reader = new EntityReader($select);
        $reader->withOffset(10)->getSql();
    }

    public function testOrderBy(): void
    {
        $select = $this->createMock(SelectQuery::class);
        $select->expects($this->once())->method('orderBy')->with(['number' => 'DESC'])->willReturnSelf();

        $reader = new EntityReader($select);
        $reader->withSort(Sort::only(['number'])->withOrderString('-number'))->getSql();
    }

    public function testLimit(): void
    {
        $select = $this->createMock(SelectQuery::class);
        $select->expects($this->once())->method('limit')->with(5)->willReturnSelf();

        $reader = new EntityReader($select);
        $reader->withLimit(5)->getSql();
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Between;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\EqualsNull;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;
use Yiisoft\Data\Reader\Filter\In;
use Yiisoft\Data\Reader\Filter\LessThan;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Filter\Not;

final class NotHandlerTest extends BaseData
{
    public function setUp(): void
    {
        parent::setUp();

        $this->fillFixtures();
    }

    public static function dataBase(): array
    {
        return [
            'all' => [new Not(new All(new Equals('id', 1), new Equals('id', 2))), range(1, 5)],
            'any' => [new Not(new Any(new Equals('id', 1), new Equals('id', 2))), range(3, 5)],
            'between' => [new Not(new Between('balance', '10.25', '100.0')), [2, 4]],
            'equals' => [new Not(new Equals('id', 1)), range(2, 5)],
            'equals null' => [new Not(new EqualsNull('born_at')), [5]],
            'greater than' => [new Not(new GreaterThan('id', 2)), [1]],
            'greater than or equal' => [new Not(new GreaterThanOrEqual('id', 2)), [1, 2]],
            'less than' => [new Not(new LessThan('id', 2)), range(3, 5)],
            'less than or equal' => [new Not(new LessThanOrEqual('id', 2)), range(2, 5)],
            'in' => [new Not(new In('id', [1, 3, 5])), [2, 4]],
            'like' => [new Not(new Like('email', '%st')), range(1, 3)],
            'not, even, 2' => [new Not(new Not(new Equals('id', 1))), [1]],
            'not, even, 4' => [new Not(new Not(new Not(new Not(new Equals('id', 1))))), [1]],
            'not, odd, 3' => [new Not(new Not(new Not(new Equals('id', 1)))), range(2, 5)],
            'not, odd, 5' => [new Not(new Not(new Not(new Not(new Not(new Equals('id', 1)))))), range(2, 5)],
        ];
    }

    /**
     * @dataProvider dataBase
     */
    public function testBase(Not $filter, array $expectedFixtureIds): void
    {
        $expectedFixtures = array_map(
            static fn (int $id): object => (object) self::FIXTURES_USER[$id - 1],
            $expectedFixtureIds,
        );
        $this->assertEquals($expectedFixtures, (new EntityReader($this->select('user')))->withFilter($filter)->read());
    }

    public function testNotSupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new Not(new NotSupportedFilter()));
    }
}

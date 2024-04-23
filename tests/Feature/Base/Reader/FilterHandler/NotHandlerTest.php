<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader\FilterHandler;

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

abstract class NotHandlerTest extends BaseData
{
    public function setUp(): void
    {
        parent::setUp();

        $this->fillFixtures();
    }

    public static function dataBase(): array
    {
        return [
            'all' => [new Not(new All(new Equals('number', 1), new Equals('number', 2))), range(1, 5)],
            'any' => [new Not(new Any(new Equals('number', 1), new Equals('number', 2))), range(3, 5)],
            'between' => [new Not(new Between('balance', '10.25', '100.0')), [2, 4]],
            'equals' => [new Not(new Equals('number', 1)), range(2, 5)],
            'equals null' => [new Not(new EqualsNull('born_at')), [5]],
            'greater than' => [new Not(new GreaterThan('number', 2)), [1]],
            'greater than or equal' => [new Not(new GreaterThanOrEqual('number', 2)), [1, 2]],
            'less than' => [new Not(new LessThan('number', 2)), range(3, 5)],
            'less than or equal' => [new Not(new LessThanOrEqual('number', 2)), range(2, 5)],
            'in' => [new Not(new In('number', [1, 3, 5])), [2, 4]],
            'like' => [new Not(new Like('email', '%st')), range(1, 3)],
            'not, even, 2' => [new Not(new Not(new Equals('number', 1))), [1]],
            'not, even, 4' => [new Not(new Not(new Not(new Not(new Equals('number', 1))))), [1]],
            'not, odd, 3' => [new Not(new Not(new Not(new Equals('number', 1)))), range(2, 5)],
            'not, odd, 5' => [new Not(new Not(new Not(new Not(new Not(new Equals('number', 1)))))), range(2, 5)],
        ];
    }

    /**
     * @dataProvider dataBase
     */
    public function testBase(Not $filter, array $expectedFixtureNumbers): void
    {
        $expectedFixtureIndexes = array_map(static fn (int $number): int => $number - 1, $expectedFixtureNumbers);
        $this->assertFixtures(
            $expectedFixtureIndexes,
            (new EntityReader($this->select('user')))->withFilter($filter)->read(),
        );
    }

    public function testNotSupportedFilterException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new Not(new NotSupportedFilter()));
    }
}

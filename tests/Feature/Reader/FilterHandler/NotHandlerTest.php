<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\BaseData;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\Not;
use Yiisoft\Data\Reader\FilterInterface;

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
            'equals' => [new Not(new Equals('id', 1)), range(2, 5)],
            'all' => [new Not(new All(new Equals('id', 1), new Equals('id', 2))), range(1, 5)],
            'any' => [new Not(new Any(new Equals('id', 1), new Equals('id', 2))), range(3, 5)],
            'not, even, 2' => [new Not(new Not(new Equals('id', 1))), [1]],
            'not, even, 4' => [new Not(new Not(new Not(new Not(new Equals('id', 1))))), [1]],
            'not, odd, 3' => [new Not(new Not(new Not(new Equals('id', 1)))), range(2, 5)],
            'not, odd, 5' => [new Not(new Not(new Not(new Not(new Not(new Equals('id', 1)))))), range(2, 5)],
        ];
    }

    /**
     * @dataProvider dataBase
     */
    public function testBase(FilterInterface $filter, array $expectedFixtureIds): void
    {
        $expectedFixtures = array_map(
            static fn (int $id): object => (object) self::FIXTURES_USER[$id - 1],
            $expectedFixtureIds,
        );
        $this->assertEquals($expectedFixtures, (new EntityReader($this->select('user')))->withFilter($filter)->read());
    }
}

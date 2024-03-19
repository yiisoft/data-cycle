<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Data\Reader;

use Yiisoft\Data\Cycle\Tests\Unit\Data\Reader\Filter\NotSupportedFilter;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;
use Yiisoft\Data\Reader\Filter\In;
use Yiisoft\Data\Reader\Filter\LessThan;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCollection;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Reader\FilterHandler;
use Yiisoft\Data\Cycle\Tests\Feature\Data\BaseData;

final class EntityReaderTest extends BaseData
{
    public function testReadOne(): void
    {
        $this->fillFixtures();

        $reader = new EntityReader($this->select('user'));

        self::assertEquals(self::FIXTURES_USER[0], (array)$reader->readOne());
    }

    public function testReadOneFromItemsCache(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withLimit(3);

        $ref = (new \ReflectionProperty($reader, 'itemsCache'));
        $ref->setAccessible(true);

        self::assertFalse($ref->getValue($reader)->isCollected());
        $reader->read();

        self::assertTrue($ref->getValue($reader)->isCollected());

        self::assertEquals(self::FIXTURES_USER[0], (array)$reader->readOne());
        self::assertEquals($ref->getValue($reader)->getCollection()[0], $reader->readOne());
    }

    public function testGetIterator(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withLimit(1);
        self::assertEquals(self::FIXTURES_USER[0], (array) \iterator_to_array($reader->getIterator())[0]);

        $ref = (new \ReflectionProperty($reader, 'itemsCache'));
        $ref->setAccessible(true);

        $cache = new CachedCollection();
        $cache->setCollection([['foo' => 'bar']]);
        $ref->setValue($reader, $cache);

        self::assertSame(['foo' => 'bar'], (array) \iterator_to_array($reader->getIterator())[0]);
    }

    public function testRead(): void
    {
        $this->fillFixtures();

        $reader = new EntityReader($this->select('user'));

        $result = $reader->read();
        self::assertEquals(
            \array_map(static fn (array $data): \stdClass => (object) $data, self::FIXTURES_USER),
            $result,
        );
    }

    public function testWithSort(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader(
            $this->select('user'),
        ))
            // Reverse order
            ->withSort(Sort::only(['id'])->withOrderString('-id'));

        $result = $reader->read();
        self::assertEquals(
            \array_map(static fn (array $data): object => (object) $data, \array_reverse(self::FIXTURES_USER)),
            $result,
        );
        self::assertSame('-id', $reader->getSort()->getOrderAsString());
    }

    public function testGetSort(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')));

        self::assertNull($reader->getSort());

        $sort = Sort::only(['id'])->withOrderString('-id');
        $reader = $reader->withSort($sort);

        self::assertSame($sort, $reader->getSort());
    }

    public function testCount(): void
    {
        $this->fillFixtures();

        $reader = new EntityReader($this->select('user'));

        self::assertSame(count(self::FIXTURES_USER), $reader->count());
    }

    /**
     * The limit option mustn't affect the count result.
     */
    public function testCountWithLimit(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader(
            $this->select('user'),
        ))->withLimit(1);

        self::assertSame(count(self::FIXTURES_USER), $reader->count());
    }

    public function testCountWithFilter(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('id', 2));

        self::assertSame(1, $reader->count());
    }

    public function testLimit(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader(
            $this->select('user'),
        ))
            ->withLimit(2);

        self::assertEquals(
            [(object)self::FIXTURES_USER[0], (object)self::FIXTURES_USER[1]],
            $reader->read(),
        );
    }

    public function testLimitException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new EntityReader($this->select('user')))->withLimit(-1);
    }

    public function testLimitOffset(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader(
            $this->select('user'),
        ))
            ->withLimit(2)->withOffset(1);

        self::assertEquals(
            [(object)self::FIXTURES_USER[1], (object)self::FIXTURES_USER[2]],
            $reader->read(),
        );
    }

    public function testFilter(): void
    {
        $this->fillFixtures();

        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('id', 2));

        self::assertEquals([(object)self::FIXTURES_USER[1]], $reader->read());
    }

    public function testFilterHandlers(): void
    {
        $default = [
            All::class => new FilterHandler\AllHandler(),
            Any::class => new FilterHandler\AnyHandler(),
            Equals::class => new FilterHandler\EqualsHandler(),
            GreaterThan::class => new FilterHandler\GreaterThanHandler(),
            GreaterThanOrEqual::class => new FilterHandler\GreaterThanOrEqualHandler(),
            In::class => new FilterHandler\InHandler(),
            LessThan::class => new FilterHandler\LessThanHandler(),
            LessThanOrEqual::class => new FilterHandler\LessThanOrEqualHandler(),
            Like::class => new FilterHandler\LikeHandler(),
        ];
        $custom = $this->createMock(FilterHandler\CompareHandler::class);
        $custom->method('getFilterClass')->willReturn('custom');

        $reader = new EntityReader($this->select('user'));
        $ref = new \ReflectionProperty(EntityReader::class, 'filterHandlers');
        $ref->setAccessible(true);

        self::assertEquals($default, $ref->getValue($reader));
        $reader = $reader->withFilterHandlers($custom);
        self::assertEquals($default + ['custom' => $custom], $ref->getValue($reader));
    }

    public function testGetSql(): void
    {
        $expected = 'SELECT "user"."id" AS "c0", "user"."email" AS "c1", "user"."balance" AS "c2"
            FROM "user" AS "user" LIMIT 2 OFFSET 1';

        $reader = (new EntityReader($this->select('user')))->withLimit(2)->withOffset(1);

        self::assertEquals(
            \preg_replace('/\s+/', '', $expected),
            \preg_replace('/\s+/', '', $reader->getSql())
        );
    }

    public function testMakeFilterClosureException(): void
    {
        $this->expectException(\RuntimeException::class);
        $filterClassName = NotSupportedFilter::class;
        $this->expectExceptionMessage("Filter \"$filterClassName\" is not supported.");
        (new EntityReader($this->select('user')))
            ->withFilter((new All(new Equals('email', 'seed@beat'), new NotSupportedFilter())))
            ->getSql();
    }
}

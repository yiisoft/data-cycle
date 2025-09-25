<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader;

use Cycle\Database\Exception\StatementException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCollection;
use Yiisoft\Data\Cycle\Reader\EntityReader;
use Yiisoft\Data\Cycle\Tests\Feature\DataTrait;
use Yiisoft\Data\Cycle\Tests\Support\NotSupportedFilter;
use Yiisoft\Data\Cycle\Tests\Support\StubFilter;
use Yiisoft\Data\Cycle\Tests\Support\StubFilterHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Sort;
use Yiisoft\Data\Tests\Common\FixtureTrait;

abstract class BaseEntityReaderTestCase extends TestCase
{
    use DataTrait;
    use FixtureTrait {
        DataTrait::assertFixtures insteadof FixtureTrait;
    }

    public function testReadOne(): void
    {
        $reader = new EntityReader($this->select('user'));
        $this->assertFixtures([0], [$reader->readOne()]);
    }

    public function testReadOneFromItemsCache(): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(3);

        $ref = (new \ReflectionProperty($reader, 'itemsCache'));

        self::assertFalse($ref->getValue($reader)->isCollected());
        $reader->read();

        self::assertTrue($ref->getValue($reader)->isCollected());

        $this->assertFixtures([0], [$reader->readOne()]);
        self::assertEquals($ref->getValue($reader)->getCollection()[0], $reader->readOne());
    }

    public function testGetIterator(): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(1);
        $this->assertFixtures([0], [\iterator_to_array($reader->getIterator())[0]]);

        $ref = (new \ReflectionProperty($reader, 'itemsCache'));

        $cache = new CachedCollection();
        $cache->setCollection([['foo' => 'bar']]);
        $ref->setValue($reader, $cache);

        self::assertSame(['foo' => 'bar'], (array) \iterator_to_array($reader->getIterator())[0]);
    }

    public function testRead(): void
    {
        $reader = new EntityReader($this->select('user'));
        $this->assertFixtures(range(0, 4), $reader->read());
    }

    public function testWithSort(): void
    {
        $reader = (new EntityReader(
            $this->select('user'),
        ))
            // Reverse order
            ->withSort(Sort::only(['number'])->withOrderString('-number'));

        $this->assertFixtures(array_reverse(range(0, 4)), $reader->read());
        self::assertSame('-number', $reader->getSort()->getOrderAsString());
    }

    public function testGetSort(): void
    {
        $reader = (new EntityReader($this->select('user')));

        self::assertNull($reader->getSort());

        $sort = Sort::only(['number'])->withOrderString('-number');
        $reader = $reader->withSort($sort);

        self::assertSame($sort, $reader->getSort());
    }

    public function testCount(): void
    {
        $reader = new EntityReader($this->select('user'));

        self::assertSame(count($this->getFixtures()), $reader->count());
    }

    /**
     * The limit option mustn't affect the count result.
     */
    public function testCountWithLimit(): void
    {
        $reader = (new EntityReader(
            $this->select('user'),
        ))->withLimit(1);

        self::assertSame(count($this->getFixtures()), $reader->count());
    }

    public function testCountWithFilter(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('number', 2));

        self::assertSame(1, $reader->count());
    }

    public function testLimit(): void
    {
        $reader = (new EntityReader(
            $this->select('user'),
        ))
            ->withLimit(2);
        $this->assertFixtures([0, 1], $reader->read());
    }

    public function testLimitException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new EntityReader($this->select('user')))->withLimit(-1);
    }

    public function testLimitOffset(): void
    {
        $reader = (new EntityReader(
            $this->select('user'),
        ))
            ->withLimit(2)->withOffset(1);
        $this->assertFixtures([1, 2], $reader->read());
    }

    public function testFilter(): void
    {
        $reader = (new EntityReader($this->select('user')))->withFilter(new Equals('number', 2));
        $this->assertFixtures([1], $reader->read());
    }

    public function testFilterHandlers(): void
    {
        $baseReader = (new EntityReader($this->select('user')))->withAddedFilterHandlers(new StubFilterHandler());

        $reader = $baseReader->withFilter(new Equals('number', 2));
        $this->assertFixtures([1], $reader->read());

        $reader = $reader->withFilter(new StubFilter());
        $this->expectException(StatementException::class);
        $this->expectExceptionMessageMatches('/symbol/i');
        $reader->read();
    }

    public static function dataGetSql(): array
    {
        return [
            'base' => [
                <<<SQL
                SELECT
                    "user"."id" AS "c0",
                    "user"."number" AS "c1",
                    "user"."email" AS "c2",
                    "user"."balance" AS "c3",
                    "user"."born_at" AS "c4"
                FROM "user" AS "user"
                LIMIT 2
                OFFSET 1
SQL,
            ],
        ];
    }

    #[DataProvider('dataGetSql')]
    public function testGetSql(string $expectedSql): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(2)->withOffset(1);
        $this->assertSame(\preg_replace('/\s+/', '', $expectedSql), \preg_replace('/\s+/', '', $reader->getSql()));
    }

    public function testMakeFilterClosureException(): void
    {
        $reader = (new EntityReader($this->select('user')));

        $this->expectException(NotSupportedFilterException::class);
        $this->expectExceptionMessage(sprintf('Filter "%s" is not supported.', NotSupportedFilter::class));
        $reader->withFilter(new NotSupportedFilter());
    }
}

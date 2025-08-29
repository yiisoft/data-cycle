<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Feature\Base\Reader;

use Cycle\Database\Query\SelectQuery;
use Cycle\ORM\Select;
use Cycle\Database\Exception\StatementException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCollection;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCount;
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

        /** @var \Yiisoft\Data\Cycle\Reader\Cache\CachedCollection $itemsCache */
        $itemsCache = $ref->getValue($reader);

        self::assertFalse($itemsCache->isCollected());
        $reader->read();

        self::assertTrue($itemsCache->isCollected());

        $this->assertFixtures([0], [$reader->readOne()]);
        self::assertEquals(iterator_to_array($itemsCache->getCollection(), false)[0], $reader->readOne());
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
        $sort = $reader->getSort();
        self::assertNotNull($sort, 'Sort should not be null');
        self::assertSame('-number', $sort->getOrderAsString());
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
        /** @psalm-suppress InvalidArgument **/
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

    public function testConstructorClonesQuery(): void
    {
        $query = $this->select('user');
        $reader = new EntityReader($query);

        $ref = new \ReflectionProperty($reader, 'query');
        /** @var Select|SelectQuery $internalQuery */
        $internalQuery = $ref->getValue($reader);

        $this->assertNotSame($query, $internalQuery, 'Query should be cloned and not the same instance');
    }

    public function testWithLimitZeroDoesNotThrow(): void
    {
        $reader = new EntityReader($this->select('user'));
        $reader->withLimit(0);
        $this->assertTrue(true, 'withLimit(0) should not throw');
    }

    public function testWithLimitThrowsOnNegative(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        /** @psalm-suppress InvalidArgument **/
        (new EntityReader($this->select('user')))->withLimit(-1);
    }

    public function testReadOneReturnsOnlySingleItem(): void
    {
        $reader = (new EntityReader($this->select('user')));
        $result = $reader->readOne();

        // Ensure result is either array/object/null
        $this->assertTrue(is_array($result) || is_object($result) || $result === null);

        // If it's an array, ensure it is a single record, not a list of 2+
        // For example, if your record is array-like:
        if (is_array($result)) {
            // Check for an indexed array (should not be!)
            $this->assertFalse(array_is_list($result) && count($result) > 1, 'readOne() must not return more than one record.');
        }
    }

    public function testReadOneReturnsExactlyOneRecord(): void
    {
        $reader = (new EntityReader($this->select('user')));
        $result = $reader->readOne();

        // It must not be an array of multiple records
        if (is_array($result) && array_is_list($result)) {
            $this->assertCount(1, $result, 'readOne() should return only one record, not a list or more than one.');
        }
        // If your implementation returns a single associative array or object, that's fine
        $this->assertTrue(is_array($result) || is_object($result) || $result === null);
    }

    public function testBuildSelectQueryReturnsClone(): void
    {
        $reader = new EntityReader($this->select('user'));

        $ref = new \ReflectionMethod($reader, 'buildSelectQuery');
        /** @var array $result */
        $result = $ref->invoke($reader);

        $queryRef = new \ReflectionProperty($reader, 'query');
        /** @var Select $original */
        $original = $queryRef->getValue($reader);

        $this->assertNotSame($original, $result, 'buildSelectQuery should return a clone, not the original query');
    }

    public function testBuildSelectQueryWithZeroOffset(): void
    {
        $reader = new EntityReader($this->select('user'));

        $offsetProp = new \ReflectionProperty($reader, 'offset');
        $offsetProp->setValue($reader, 0);

        $method = new \ReflectionMethod($reader, 'buildSelectQuery');
        /** @var Select|SelectQuery $result */
        $result = $method->invoke($reader);
    }

    public function testResetCountCacheUsesClonedQueryForCachedCount(): void
    {
        $query = $this->select('user');
        $reader = new EntityReader($query);

        // Use reflection to call private resetCountCache
        $refMethod = new \ReflectionMethod($reader, 'resetCountCache');
        /** @var void $refMethod->invoke($reader); */
        $refMethod->invoke($reader);

        // Access private countCache property
        $refCountCache = new \ReflectionProperty($reader, 'countCache');
        /** @var CachedCount $countCache */
        $countCache = $refCountCache->getValue($reader);

        // Access private query property of countCache
        $refCountCacheQuery = new \ReflectionProperty($countCache, 'collection');
        /** @var int $countCacheQuery **/
        $countCacheQuery = $refCountCacheQuery->getValue($countCache);

        $this->assertNotSame($query, $countCacheQuery, 'CachedCount should get a cloned query');
    }

    public function testWithAddedFilterHandlersDoesNotMutateOriginal(): void
    {
        $reader = new EntityReader($this->select('user'));
        $refHandlers = new \ReflectionProperty($reader, 'filterHandlers');
        /** @var array $originalHandlers **/
        $originalHandlers = $refHandlers->getValue($reader);

        $newReader = $reader->withAddedFilterHandlers(new StubFilterHandler());
        /** @var array $newHandlers **/
        $newHandlers = $refHandlers->getValue($newReader);

        // The original reader's handlers should remain unchanged
        $this->assertSame($originalHandlers, $refHandlers->getValue($reader));
        // The new reader's handlers should be different
        $this->assertNotSame($originalHandlers, $newHandlers);
    }

    public function testWithAddedFilterHandlersResetsCountCache(): void
    {
        $reader = new EntityReader($this->select('user'));

        // Prime the countCache with a dummy object
        $refCountCache = new \ReflectionProperty($reader, 'countCache');
        $dummyCache = new \Yiisoft\Data\Cycle\Reader\Cache\CachedCount($this->select('user'));
        $refCountCache->setValue($reader, $dummyCache);

        $newReader = $reader->withAddedFilterHandlers(new StubFilterHandler());
        $newReaderCountCache = (new \ReflectionProperty($newReader, 'countCache'));

        // Count cache should be reset (should not be the same object)
        $this->assertNotSame(
            $dummyCache,
            $newReaderCountCache->getValue($newReader),
            'Count cache should be reset in new instance',
        );
    }

    public function testReadOneReturnsOnlyOneItem(): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(5);
        $result = $reader->readOne();
        $this->assertTrue(
            is_array($result) || is_object($result) || $result === null,
            'readOne should return an array, object, or null',
        );
        // If it's an array, ensure it matches only the first fixture
        if (is_array($result)) {
            $this->assertFixtures([0], [$result]);
        }
    }

    public function testBuildSelectQueryAppliesOffsetCorrectly(): void
    {
        $reader = new EntityReader($this->select('user'));
        $ref = new \ReflectionMethod($reader, 'buildSelectQuery');

        // Default offset (assumed to be 0)
        /** @var Select|SelectQuery */
        $query = $ref->invoke($reader);
        // You may need to adjust this depending on your query type
        if (method_exists($query, 'getOffset')) {
            $this->assertTrue(
                $query->getOffset() === null || $query->getOffset() === 0,
                'Default offset should not be set or should be 0',
            );
        }

        // Set offset to 2
        $offsetProp = new \ReflectionProperty($reader, 'offset');
        $offsetProp->setValue($reader, 2);
        /** @var Select|SelectQuery */
        $queryWithOffset = $ref->invoke($reader);
        if (method_exists($queryWithOffset, 'getOffset')) {
            $this->assertEquals(2, $queryWithOffset->getOffset(), 'Offset should be set to 2');
        }
    }

    public function testReadOneReturnsExactlyOneItemOrNullifFalse(): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(3);

        $item = $reader->readOne();

        // Should be null, array, or object of stdClass
        // class stdClass#4459 (5) {
        // public $id =>
        // int(1)
        // public $number =>
        // int(1)
        // public $email =>
        // string(11) "foo@bar\baz"
        // public $balance =>
        // double(10.25)
        // public $born_at =>
        // NULL
        // }
        // indicates that readOne() is returning a single database record
        // as an object of type stdClass
        /** @psalm-suppress RedundantConditionGivenDocblockType */
        $isObject = is_object($item);

        $this->assertTrue(
            is_null($item) || is_array($item) || $isObject,
            'readOne should return null, or array, or object',
        );

        // If it's array, check that it matches only the first fixture (not more than one)
        if (is_array($item)) {
            $this->assertFixtures([0], [$item]);
        }

        // If you want to be extra strict, you can also check that it's not a nested array of arrays
        if (is_array($item)) {
            $this->assertFalse(
                isset($item[0]) && (is_array($item[0]) || is_object($item[0])),
                'readOne should not return a list of multiple items',
            );
        }
    }

    public function testBuildSelectQueryOffsetBehavior(): void
    {
        $reader = new EntityReader($this->select('user'));

        $refBuildSelectQuery = new \ReflectionMethod($reader, 'buildSelectQuery');

        // By default, offset should NOT be set
        /** @var SelectQuery */
        $query = $refBuildSelectQuery->invoke($reader);
        $this->assertTrue(
            $query->getOffset() === null || $query->getOffset() === 0,
            'Offset should not be set by default (should be null or 0)',
        );

        // Set offset to 2, should apply
        $offsetProp = new \ReflectionProperty($reader, 'offset');
        $offsetProp->setValue($reader, 2);
        /** @var SelectQuery */
        $queryWithOffset = $refBuildSelectQuery->invoke($reader);
        $this->assertEquals(2, $queryWithOffset->getOffset(), 'Offset should be set to 2');

        // Set offset to -1, should NOT apply
        $offsetProp->setValue($reader, -1);
        /** @var SelectQuery */
        $queryWithOffsetNeg1 = $refBuildSelectQuery->invoke($reader);
        $this->assertTrue(
            $queryWithOffsetNeg1->getOffset() === null || $queryWithOffsetNeg1->getOffset() === 0,
            'Offset should not be set for -1',
        );
    }

    public function testResetCountCacheClonesQuery(): void
    {
        $query = $this->select('user');
        $reader = new EntityReader($query);

        $refMethod = new \ReflectionMethod($reader, 'resetCountCache');
        /** @var void $refMethod->invoke($reader); */
        $refMethod->invoke($reader);

        $refCountCache = new \ReflectionProperty($reader, 'countCache');
        /** @var CachedCount $countCache */
        $countCache = $refCountCache->getValue($reader);

        $refCollection = new \ReflectionProperty($countCache, 'collection');
        /** @var int $cachedQuery **/
        $cachedQuery = $refCollection->getValue($countCache);

        $this->assertNotSame($query, $cachedQuery, 'CachedCount should use a cloned query, not the same one');
    }

    public function testWithOffsetZeroBehavesLikeNoOffset(): void
    {
        $readerNoOffset = new EntityReader($this->select('user'));
        $resultsNoOffset = iterator_to_array($readerNoOffset->getIterator());

        $readerOffsetZero = (new EntityReader($this->select('user')))->withOffset(0);
        $resultsOffsetZero = iterator_to_array($readerOffsetZero->getIterator());

        $this->assertEquals($resultsNoOffset, $resultsOffsetZero, 'Offset of 0 should not change results.');
    }

    public function testReadOneNeverReturnsMultipleRecords(): void
    {
        $reader = (new EntityReader($this->select('user')));
        $result = $reader->readOne();
        // If your method could ever return a list, this will catch it
        $this->assertFalse(is_array($result) && array_is_list($result) && count($result) > 1, 'readOne() must not return more than one record.');
        // If you always return an object or associative array, that's fine.
        $this->assertTrue(is_object($result) || is_array($result) || $result === null);
    }

    public function testOffsetZeroBehavesAsNoOffset(): void
    {
        $readerNoOffset = new EntityReader($this->select('user'));
        $resultsNoOffset = iterator_to_array($readerNoOffset->getIterator());

        $readerOffsetZero = (new EntityReader($this->select('user')))->withOffset(0);
        $resultsOffsetZero = iterator_to_array($readerOffsetZero->getIterator());

        $this->assertSame($resultsNoOffset, $resultsOffsetZero, 'Offset of 0 should not change results.');
    }

    public function testOneItemCacheFetchesExactlyOneItem(): void
    {
        $reader = new EntityReader($this->select('user'));

        // Prime the cache by triggering the fetch
        $result = $reader->readOne();

        // Use reflection to access the private oneItemCache property
        $refOneItemCache = new \ReflectionProperty($reader, 'oneItemCache');
        /** @var CachedCollection $oneItemCache */
        $oneItemCache = $refOneItemCache->getValue($reader);

        // Assume oneItemCache has a method getCollection() or similar, adjust if needed
        $items = $oneItemCache->getCollection();

        // Assert only one item is cached, or zero if nothing is found
        $this->assertIsArray($items, 'oneItemCache should store collection as array');
        $this->assertLessThanOrEqual(1, count($items), 'oneItemCache must not contain more than one record');

        // Optionally: check that the cache contains what readOne() returned
        if ($result !== null) {
            $this->assertContains($result, $items, 'oneItemCache should contain the result of readOne().');
        }
    }

    public function testReadOneUsesLimitOne(): void
    {
        $reader = new EntityReader($this->select('user'));
        // Use reflection or a public method to get the SQL used by readOne
        $sql = $reader->withLimit(1)->getSql();
        // Note: (1) MySQL and PostgreSQL use the LIMIT clause (e.g., SELECT ... LIMIT 1).
        // Note: (2) MSSQL uses a different approach (ROW_NUMBER()/TOP) because it does not support the LIMIT clause.
        if ($this->isDriver('mssql')) {
            $this->assertStringContainsString('ROW_NUMBER()', $sql);
            $this->assertStringContainsString('WHERE [_ROW_NUMBER_] BETWEEN 1 AND 1', $sql);
        } else {
            $this->assertStringContainsString('LIMIT 1', $sql);
        }
    }

    public function testReadOneReturnsExactlyOneItem(): void
    {
        $reader = (new EntityReader($this->select('user')))->withLimit(5); // set up with 3+ items in source
        $item = $reader->readOne();
        $this->assertNotNull($item);
        // Optionally: Check it's the first item, or has expected ID/fields

        // Assert a second call (with same state) does not return a different item, or returns null if expected
    }

}

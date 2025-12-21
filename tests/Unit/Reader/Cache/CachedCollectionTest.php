<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\Cache;

use ArrayIterator;
use Generator;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCollection;

final class CachedCollectionTest extends TestCase
{
    public function testCollection(): void
    {
        $collection = new ArrayIterator(['foo']);

        $cachedCollection = new CachedCollection();

        $this->assertNull($cachedCollection->getCollection());

        $cachedCollection->setCollection($collection);

        $this->assertSame($collection, $cachedCollection->getCollection());
    }

    public function testIsCollected(): void
    {
        $cachedCollection = new CachedCollection();

        $this->assertFalse($cachedCollection->isCollected());

        $cachedCollection->setCollection(new ArrayIterator());

        $this->assertTrue($cachedCollection->isCollected());
    }

    public function testGetGenerator(): void
    {
        $collection = new ArrayIterator(['foo']);

        $cachedCollection = new CachedCollection();

        $cachedCollection->setCollection($collection);

        $this->assertSame(['foo'], iterator_to_array($cachedCollection->getGenerator()));
    }
}

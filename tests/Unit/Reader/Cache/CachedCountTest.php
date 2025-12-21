<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Unit\Reader\Cache;

use Countable;
use PHPUnit\Framework\TestCase;
use Yiisoft\Data\Cycle\Reader\Cache\CachedCount;

final class CachedCountTest extends TestCase
{
    public function testGetCount(): void
    {
        $collection = $this->createMock(Countable::class);
        $collection->expects($this->once())->method('count')->willReturn(2);

        $cached = new CachedCount($collection);

        $this->assertSame(2, $cached->getCount());

        // must return cached value and not call count() again
        $this->assertSame(2, $cached->getCount());
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\Cache;

use Countable;

final class CachedCount
{
    /**
     * @psalm-var non-negative-int|null
     */
    private ?int $count = null;

    public function __construct(private ?Countable $collection)
    {
    }

    /**
     * @psalm-internal Yiisoft\Data\Cycle\Reader
     *
     * @psalm-return non-negative-int
     */
    public function getCount(): int
    {
        return $this->count ?? $this->cacheCount();
    }

    /**
     * @psalm-return non-negative-int
     */
    private function cacheCount(): int
    {
        /**
         * @psalm-suppress PossiblyNullReference
         *
         * @psalm-var non-negative-int
         */
        $this->count = $this->collection->count();
        $this->collection = null;

        return $this->count;
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader;

use Yiisoft\Data\Reader\FilterInterface;

interface QueryBuilderFilterHandler
{
    /**
     * Get matching filter class name.
     *
     * If the filter is active, a corresponding handler will be used during matching.
     *
     * @return string The filter class name.
     *
     * @psalm-return class-string
     */
    public function getFilterClass(): string;

    /**
     * @psalm-param array<class-string, QueryBuilderFilterHandler> $handlers
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array;
}

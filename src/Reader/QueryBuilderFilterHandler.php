<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader;

use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

interface QueryBuilderFilterHandler
{
    /**
     * @psalm-param array<class-string, FilterHandlerInterface & QueryBuilderFilterHandler> $handlers
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array;
}

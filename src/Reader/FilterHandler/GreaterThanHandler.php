<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class GreaterThanHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return GreaterThan::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var GreaterThan $filter */

        return [$filter->field, '>', $filter->value];
    }
}

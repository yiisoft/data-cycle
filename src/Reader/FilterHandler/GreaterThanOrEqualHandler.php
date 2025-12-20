<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;
use Yiisoft\Data\Reader\FilterInterface;

final class GreaterThanOrEqualHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getFilterClass(): string
    {
        return GreaterThanOrEqual::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var GreaterThanOrEqual $filter */

        return [$filter->field, '>=', $filter->value];
    }
}

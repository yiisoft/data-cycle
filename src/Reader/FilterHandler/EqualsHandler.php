<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class EqualsHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    #[\Override]
    public function getFilterClass(): string
    {
        return Equals::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Equals $filter */

        return [$filter->field, '=', $filter->value];
    }
}

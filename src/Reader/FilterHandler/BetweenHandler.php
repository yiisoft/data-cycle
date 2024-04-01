<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Between;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class BetweenHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return Between::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Between) {
            throw new UnexpectedFilterException(Between::class, $filter::class);
        }

        return [$filter->getField(), 'between', $filter->getMinValue(), $filter->getMaxValue()];
    }
}

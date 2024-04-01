<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\EqualsNull;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class EqualsNullHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return EqualsNull::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof EqualsNull) {
            throw new UnexpectedFilterException(EqualsNull::class, $filter::class);
        }

        return [$filter->getField(), '=', null];
    }
}

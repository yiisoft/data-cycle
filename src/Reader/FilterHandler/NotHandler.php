<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Injection\Parameter;
use RuntimeException;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Reader\Filter\Between;
use Yiisoft\Data\Reader\Filter\Equals;
use Yiisoft\Data\Reader\Filter\EqualsNull;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\Filter\GreaterThanOrEqual;
use Yiisoft\Data\Reader\Filter\In;
use Yiisoft\Data\Reader\Filter\LessThan;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\Filter\Not;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class NotHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return Not::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Not) {
            throw new UnexpectedFilterException(Not::class, $filter::class);
        }

        $convertedFilter = $this->convertFilter($filter->getFilter());
        $handledFilter = $convertedFilter instanceof Not ? $convertedFilter->getFilter() : $convertedFilter;
        $handler = $handlers[$handledFilter::class] ?? null;
        if ($handler === null) {
            throw new NotSupportedFilterException($handledFilter::class);
        }

        $where = $handler->getAsWhereArguments($handledFilter, $handlers);
        if (!is_array($where) || !array_key_exists(1, $where)) {
            return $where;
        }

        $operator = $where[1];
        $convertedOperator = match ($operator) {
            'between', 'like' => "not $operator",
            '=' => '!=',
        };

        $where[1] = $convertedOperator;

        return $where;
    }

    private function convertFilter(FilterInterface $filter): FilterInterface
    {
        $handler = $this;

        return match ($filter::class) {
            All::class => new Any(
                ...array_map(
                    static fn (FilterInterface $subFilter): FilterInterface => $handler->convertFilter($subFilter),
                    $filter->getFilters(),
                ),
            ),
            Any::class => new All(
                ...array_map(
                    static fn (FilterInterface $subFilter): FilterInterface => $handler->convertFilter($subFilter),
                    $filter->getFilters(),
                ),
            ),
            GreaterThan::class => new LessThan($filter->getField(), $filter->getValue()),
            GreaterThanOrEqual::class => new LessThanOrEqual($filter->getField(), $filter->getValue()),
            LessThan::class => new GreaterThan($filter->getField(), $filter->getValue()),
            LessThanOrEqual::class => new GreaterThanOrEqual($filter->getField(), $filter->getValue()),
            Between::class, Equals::class, EqualsNull::class, In::class, Like::class => new Not($filter),
            Not::class => $this->convertFilter($filter->getFilter()),
            default => throw new NotSupportedFilterException($filter::class),
        };
    }
}

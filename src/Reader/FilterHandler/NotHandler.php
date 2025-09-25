<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\AndX;
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
use Yiisoft\Data\Reader\Filter\OrX;
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
        /** @var Not $filter */

        $convertedFilter = $this->convertFilter($filter->filter);
        $handledFilter = $convertedFilter instanceof Not ? $convertedFilter->filter : $convertedFilter;
        $handler = $handlers[$handledFilter::class] ?? null;
        if ($handler === null) {
            throw new NotSupportedFilterException($handledFilter::class);
        }

        $where = $handler->getAsWhereArguments($handledFilter, $handlers);
        if (!$convertedFilter instanceof Not) {
            return $where;
        }

        $operator = $where[1];
        $where[1] = match ($operator) {
            'between', 'in', 'like' => "not $operator",
            '=' => '!=',
            default => $operator,
        };

        return $where;
    }

    private function convertFilter(FilterInterface $filter, int $notCount = 1): FilterInterface
    {
        $handler = $this;

        return match ($filter::class) {
            AndX::class => new OrX(
                ...array_map(
                    static fn (FilterInterface $subFilter): FilterInterface => $handler->convertFilter($subFilter),
                    $filter->filters,
                ),
            ),
            OrX::class => new AndX(
                ...array_map(
                    static fn (FilterInterface $subFilter): FilterInterface => $handler->convertFilter($subFilter),
                    $filter->filters,
                ),
            ),
            GreaterThan::class => new LessThanOrEqual($filter->field, $filter->value),
            GreaterThanOrEqual::class => new LessThan($filter->field, $filter->value),
            LessThan::class => new GreaterThanOrEqual($filter->field, $filter->value),
            LessThanOrEqual::class => new GreaterThan($filter->field, $filter->value),
            Between::class, Equals::class, EqualsNull::class, In::class, Like::class => new Not($filter),
            Not::class => $this->convertNot($filter, $notCount),
            default => $filter,
        };
    }

    private function convertNot(Not $filter, int $notCount): FilterInterface
    {
        $notCount++;

        if ($filter->filter instanceof Not) {
            return $this->convertFilter($filter->filter, $notCount);
        }

        return $notCount % 2 === 1 ? new Not($filter->filter) : $filter->filter;
    }
}

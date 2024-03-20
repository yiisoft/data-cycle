<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class AllHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return All::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof All) {
            throw new UnexpectedFilterException(All::class, $filter::class);
        }

        return [
            static function (QueryBuilder $select) use ($filter, $handlers) {
                foreach ($filter->getFilters() as $subFilter) {
                    $handler = $handlers[$subFilter::class] ?? null;
                    if ($handler === null) {
                        throw new \RuntimeException(sprintf('Filter "%s" is not supported.', $subFilter::class));
                    }
                    /** @var QueryBuilderFilterHandler $handler */
                    $select->where(...$handler->getAsWhereArguments($subFilter, $handlers));
                }
            },
        ];
    }
}

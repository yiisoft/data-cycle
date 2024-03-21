<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\Any;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class AnyHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return Any::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Any) {
            throw new UnexpectedFilterException(Any::class, $filter::class);
        }

        return [
            static function (QueryBuilder $select) use ($filter, $handlers) {
                foreach ($filter->getFilters() as $subFilter) {
                    $handler = $handlers[$subFilter::class] ?? null;
                    if ($handler === null) {
                        throw new NotSupportedFilterException($subFilter::class);
                    }
                    $select->orWhere(...$handler->getAsWhereArguments($subFilter, $handlers));
                }
            },
        ];
    }
}

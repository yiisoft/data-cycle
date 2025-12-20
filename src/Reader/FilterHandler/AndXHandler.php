<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Query\SelectQuery;
use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Exception\NotSupportedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\AndX;
use Yiisoft\Data\Reader\FilterInterface;

final class AndXHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getFilterClass(): string
    {
        return AndX::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var AndX $filter */
        return [
            static function (QueryBuilder|SelectQuery $select) use ($filter, $handlers) {
                foreach ($filter->filters as $subFilter) {
                    $handler = $handlers[$subFilter::class] ?? null;
                    if ($handler === null) {
                        throw new NotSupportedFilterException($subFilter::class);
                    }
                    $select->andWhere(...$handler->getAsWhereArguments($subFilter, $handlers));
                }
            },
        ];
    }
}

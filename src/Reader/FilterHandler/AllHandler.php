<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Injection\Expression;
use Cycle\Database\Query\SelectQuery;
use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\FilterInterface;
use Override;

final class AllHandler implements QueryBuilderFilterHandler
{
    #[Override]
    public function getFilterClass(): string
    {
        return All::class;
    }

    #[Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var All $filter */
        return [
            static function (QueryBuilder|SelectQuery $select) {
                $select->where(new Expression('1 = 1'));
            },
        ];
    }
}

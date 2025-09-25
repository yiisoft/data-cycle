<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Injection\Expression;
use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\All;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class AllHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    #[\Override]
    public function getFilterClass(): string
    {
        return All::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var All $filter */
        return [
            static function (QueryBuilder $select) {
                $select->where(new Expression('1'), new Expression('1'));
            },
        ];
    }
}

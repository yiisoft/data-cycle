<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Injection\Expression;
use Cycle\ORM\Select\QueryBuilder;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\None;
use Yiisoft\Data\Reader\FilterInterface;

final class NoneHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getFilterClass(): string
    {
        return None::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var None $filter */
        return [
            static function (QueryBuilder $select) {
                $select->where(new Expression('1 = 0'));
            },
        ];
    }
}

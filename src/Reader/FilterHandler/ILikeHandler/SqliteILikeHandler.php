<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\ILikeHandler;

use Cycle\Database\Injection\Fragment;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\ILike;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

final class SqliteILikeHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return ILike::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof ILike) {
            throw new UnexpectedFilterException(ILike::class, $filter::class);
        }

        return [new Fragment("UPPER({$filter->getField()})"), 'like', mb_strtoupper($filter->getValue())];
    }
}

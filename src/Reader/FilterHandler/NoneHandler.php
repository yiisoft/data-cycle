<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\None;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;
use Cycle\Database\Injection\Expression;

final class NoneHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    #[\Override]
    public function getFilterClass(): string
    {
        return None::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        return [new Expression('1 = 0')];
    }
}

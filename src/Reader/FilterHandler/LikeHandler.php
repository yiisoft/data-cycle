<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use InvalidArgumentException;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

final class LikeHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return Like::class;
    }

    /**
     * @psalm-param Like $filter
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
//        if (count($arguments) !== 2) {
//            throw new InvalidArgumentException('$arguments should contain exactly two elements.');
//        }

        return [$filter->getField(), 'like', $filter->getValue()];
    }
}

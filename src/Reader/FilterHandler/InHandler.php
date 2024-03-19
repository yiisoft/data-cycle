<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Cycle\Database\Injection\Parameter;
use InvalidArgumentException;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\Filter\In;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

final class InHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return In::class;
    }

    /**
     * @psalm-param In $filter
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
//        if (count($arguments) !== 2) {
//            throw new InvalidArgumentException('$arguments should contain exactly two elements.');
//        }

        return [$filter->getField(), 'in', new Parameter($filter->getValues())];
    }
}

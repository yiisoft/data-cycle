<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use InvalidArgumentException;
use Yiisoft\Data\Reader\Filter\Compare;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterInterface;

abstract class CompareHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    abstract protected function getSymbol(): string;

    protected function validateArguments(array $arguments): void
    {
        if (count($arguments) !== 2) {
            throw new InvalidArgumentException('$arguments should contain exactly two elements.');
        }
    }

    /**
     * @psalm-param Compare $filter
     */
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        // $this->validateArguments($arguments);

        return [$filter->getField(), $this->getSymbol(), $filter->getValue()];
    }
}

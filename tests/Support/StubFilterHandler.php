<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Tests\Support;

use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\FilterHandlerInterface;
use Yiisoft\Data\Reader\FilterInterface;

final class StubFilterHandler implements QueryBuilderFilterHandler, FilterHandlerInterface
{
    public function getFilterClass(): string
    {
        return StubFilter::class;
    }

    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof StubFilter) {
            throw new UnexpectedFilterException(StubFilter::class, $filter::class);
        }

        return ['field', 'symbol', 'value'];
    }
}

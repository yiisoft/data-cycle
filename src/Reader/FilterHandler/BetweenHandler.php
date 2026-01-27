<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Between;
use Yiisoft\Data\Reader\FilterInterface;
use Override;

final class BetweenHandler implements QueryBuilderFilterHandler
{
    #[Override]
    public function getFilterClass(): string
    {
        return Between::class;
    }

    #[Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Between $filter  */

        return [$filter->field, 'between', $filter->minValue, $filter->maxValue];
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\LessThan;
use Yiisoft\Data\Reader\FilterInterface;

final class LessThanHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getFilterClass(): string
    {
        return LessThan::class;
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var LessThan $filter */

        return [$filter->field, '<', $filter->value];
    }
}

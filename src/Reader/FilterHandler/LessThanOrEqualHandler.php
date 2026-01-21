<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Override;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\LessThanOrEqual;
use Yiisoft\Data\Reader\FilterInterface;

final class LessThanOrEqualHandler implements QueryBuilderFilterHandler
{
    #[Override]
    public function getFilterClass(): string
    {
        return LessThanOrEqual::class;
    }

    #[Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var LessThanOrEqual $filter */

        return [$filter->field, '<=', $filter->value];
    }
}

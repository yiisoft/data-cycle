<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler;

use Override;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\GreaterThan;
use Yiisoft\Data\Reader\FilterInterface;

final class GreaterThanHandler implements QueryBuilderFilterHandler
{
    #[Override]
    public function getFilterClass(): string
    {
        return GreaterThan::class;
    }

    #[Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var GreaterThan $filter */

        return [$filter->field, '>', $filter->value];
    }
}

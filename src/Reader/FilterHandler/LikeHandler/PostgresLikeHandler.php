<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class PostgresLikeHandler extends BaseLikeHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Like $filter */
        $pattern = $this->prepareValue($filter->value, $filter->mode);

        if ($filter->caseSensitive !== true) {
            return [$filter->field, 'ilike', $this->prepareValue($pattern)];
        }

        return [$filter->field, 'like', $this->prepareValue($pattern)];
    }
}

<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class MysqlLikeHandler extends BaseLikeHandler implements QueryBuilderFilterHandler
{
    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Like $filter */

        if ($filter->caseSensitive !== true) {
            return [$filter->field, 'like', '%' . $this->prepareValue($filter->value) . '%'];
        }

        return [$filter->field, 'like binary', $this->prepareValue($filter->value)];
    }
}

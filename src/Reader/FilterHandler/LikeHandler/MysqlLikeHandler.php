<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class MysqlLikeHandler extends BaseLikeHandler implements QueryBuilderFilterHandler
{
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Like $filter */

        if ($filter->isCaseSensitive() !== true) {
            return [$filter->getField(), 'like', '%' . $this->prepareValue($filter->getValue()) . '%'];
        }

        return [$filter->getField(), 'like binary', $this->prepareValue($filter->getValue())];
    }
}

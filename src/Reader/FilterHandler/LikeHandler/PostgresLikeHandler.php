<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class PostgresLikeHandler extends BaseLikeHandler
{
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Like) {
            throw new UnexpectedFilterException(Like::class, $filter::class);
        }

        if ($filter->isCaseSensitive() !== true) {
            return [$filter->getField(), 'like', '%'. $filter->getValue() . '%'];
        }

        return [$filter->getField(), 'ilike', '%'. $filter->getValue() . '%'];
    }
}

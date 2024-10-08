<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Cycle\Exception\UnexpectedFilterException;
use Yiisoft\Data\Cycle\Reader\QueryBuilderFilterHandler;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class SqliteLikeHandler extends BaseLikeHandler implements QueryBuilderFilterHandler
{
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        if (!$filter instanceof Like) {
            throw new UnexpectedFilterException(Like::class, $filter::class);
        }

        if ($filter->isCaseSensitive() === true) {
            throw new NotSupportedFilterOptionException(optionName: 'caseSensitive', driverType: 'SQLite');
        }

        return [$filter->getField(), 'like', $this->prepareValue($filter->getValue())];
    }
}

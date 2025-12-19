<?php

declare(strict_types=1);

namespace Yiisoft\Data\Cycle\Reader\FilterHandler\LikeHandler;

use Yiisoft\Data\Cycle\Exception\NotSupportedFilterOptionException;
use Yiisoft\Data\Reader\Filter\Like;
use Yiisoft\Data\Reader\FilterInterface;

final class SqlServerLikeHandler extends BaseLikeHandler
{
    public function __construct()
    {
        unset($this->escapingReplacements['\\']);
    }

    #[\Override]
    public function getAsWhereArguments(FilterInterface $filter, array $handlers): array
    {
        /** @var Like $filter */

        if ($filter->caseSensitive === true) {
            throw new NotSupportedFilterOptionException(optionName: 'caseSensitive', driverType: 'SQLServer');
        }

        return [$filter->field, 'like', $this->prepareValue($filter->value, $filter->mode)];
    }
}
